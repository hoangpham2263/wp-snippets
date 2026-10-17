document.addEventListener('DOMContentLoaded', function() {
    const searchIcon = document.querySelector('#mobile-search-icon');
    const searchContainer = document.getElementById('mobile-search-container');
    
    if (searchIcon && searchContainer) {
        let isOpen = false;
        
        // Thiết lập animation sau khi đã set vị trí ban đầu trong HTML
        setTimeout(() => {
            searchContainer.style.transition = 'transform 0.3s ease-in-out';
        }, 50);
        
        searchIcon.addEventListener('click', function(e) {
            e.stopPropagation();
            
            if (isOpen) {
                // Đóng - di chuyển về bên trái
                searchContainer.style.transform = 'translateX(-100%)';
                isOpen = false;
            } else {
                // Mở - trượt ra từ trái
                searchContainer.style.transform = 'translateX(0)';
                isOpen = true;
            }
        });
        
        // Click outside để đóng search
        document.addEventListener('click', function(e) {
            if (!searchContainer.contains(e.target) && !searchIcon.contains(e.target)) {
                searchContainer.style.transform = 'translateX(-100%)';
                isOpen = false;
            }
        });
        
        // Ngăn việc đóng search khi click vào input
        const searchInput = searchContainer.querySelector('input[type="search"], input[type="text"]');
        if (searchInput) {
            searchInput.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    }
});