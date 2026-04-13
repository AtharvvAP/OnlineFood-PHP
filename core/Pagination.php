<?php
/**
 * Pagination Helper
 * For paginated results
 */

class Pagination {
    private $total;
    private $perPage;
    private $currentPage;
    private $totalPages;
    
    public function __construct($total, $perPage = null, $currentPage = 1) {
        $this->total = $total;
        $this->perPage = $perPage ?? ITEMS_PER_PAGE;
        $this->currentPage = max(1, (int)$currentPage);
        $this->totalPages = ceil($this->total / $this->perPage);
    }
    
    public function getOffset() {
        return ($this->currentPage - 1) * $this->perPage;
    }
    
    public function getLimit() {
        return $this->perPage;
    }
    
    public function getCurrentPage() {
        return $this->currentPage;
    }
    
    public function getTotalPages() {
        return $this->totalPages;
    }
    
    public function hasPages() {
        return $this->totalPages > 1;
    }
    
    public function hasPrevious() {
        return $this->currentPage > 1;
    }
    
    public function hasNext() {
        return $this->currentPage < $this->totalPages;
    }
    
    public function getPreviousPage() {
        return $this->hasPrevious() ? $this->currentPage - 1 : null;
    }
    
    public function getNextPage() {
        return $this->hasNext() ? $this->currentPage + 1 : null;
    }
    
    public function getPages($range = 5) {
        $pages = [];
        $start = max(1, $this->currentPage - floor($range / 2));
        $end = min($this->totalPages, $start + $range - 1);
        
        // Adjust start if we're near the end
        if ($end - $start < $range - 1) {
            $start = max(1, $end - $range + 1);
        }
        
        for ($i = $start; $i <= $end; $i++) {
            $pages[] = $i;
        }
        
        return $pages;
    }
    
    public function render($baseUrl = '') {
        if (!$this->hasPages()) {
            return '';
        }
        
        $html = '<nav aria-label="Page navigation"><ul class="pagination">';
        
        // Previous button
        if ($this->hasPrevious()) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $this->getPreviousPage() . '">Previous</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Previous</span></li>';
        }
        
        // Page numbers
        foreach ($this->getPages() as $page) {
            $active = $page === $this->currentPage ? ' active' : '';
            $html .= '<li class="page-item' . $active . '"><a class="page-link" href="' . $baseUrl . '?page=' . $page . '">' . $page . '</a></li>';
        }
        
        // Next button
        if ($this->hasNext()) {
            $html .= '<li class="page-item"><a class="page-link" href="' . $baseUrl . '?page=' . $this->getNextPage() . '">Next</a></li>';
        } else {
            $html .= '<li class="page-item disabled"><span class="page-link">Next</span></li>';
        }
        
        $html .= '</ul></nav>';
        
        return $html;
    }
    
    public function toArray() {
        return [
            'total' => $this->total,
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'total_pages' => $this->totalPages,
            'has_previous' => $this->hasPrevious(),
            'has_next' => $this->hasNext(),
            'previous_page' => $this->getPreviousPage(),
            'next_page' => $this->getNextPage()
        ];
    }
}
