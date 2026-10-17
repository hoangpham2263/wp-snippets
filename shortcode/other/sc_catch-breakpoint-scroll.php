<?php
function sc_breakpoint_scroll_shortcode()
{
  ob_start();
?>
  <?php
  $total_post = get_posts(array(
    'post_type' => 'product',
    'posts_per_page' => -1,
  ));
  $total_post = count($total_post);
  ?>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      let current_url = window.location.href;
      let currentValue = parseInt(sessionStorage.getItem('cs-per-page')) || 16;
      let isLoading = false;
      let hasMorePosts = true;
      const totalPost = <?php echo $total_post; ?>;

      // Hàm kiểm tra vị trí scroll
      function checkScroll() {
        const scrollTop = document.documentElement.scrollTop;
        const scrollHeight = document.documentElement.scrollHeight;
        const halfPage = (scrollHeight - window.innerHeight) * (1 / 5);
        const footer = document.querySelector('footer');
        const bottomEdge = window.scrollY + window.innerHeight;

        // Phần load more posts giữ nguyên
        if (scrollTop >= halfPage && !isLoading && hasMorePosts && currentValue < totalPost) {
          loadMorePosts();

          // Check footer tồn tại
          if (footer) {
            const tableProductList = document.querySelectorAll('.table-product-list-item-desktop');
            console.log(tableProductList);
            const locationTableProductList = tableProductList[tableProductList.length - 16].offsetTop;
            console.log(tableProductList[tableProductList.length - 16]);
            const locationFooter = footer.offsetTop;
            if (bottomEdge >= locationFooter) {
              window.scrollTo(0, locationTableProductList);
            }
          }
        }

      }

      // Hàm tải thêm bài viết
      async function loadMorePosts() {
        if (currentValue >= totalPost) {
          hasMorePosts = false;
          window.removeEventListener('scroll', checkScroll);
          return;
        }

        isLoading = true;
        currentValue += 16;
        sessionStorage.setItem('cs-per-page', currentValue);

        try {
          const response = await fetch(`${current_url}?cs-per-page=${currentValue}`);
          const text = await response.text();
          const parser = new DOMParser();
          const doc = parser.parseFromString(text, 'text/html');
          const newContent = doc.getElementById('table-product-list-no-sidebar');

          if (newContent && newContent.children.length > 0) {
            const productList = document.querySelector('#table-product-list-no-sidebar');
            productList.innerHTML = newContent.innerHTML;
          } else {
            hasMorePosts = false;
            window.removeEventListener('scroll', checkScroll);
          }
        } catch (error) {
          console.error('Error:', error);
        } finally {
          isLoading = false;
        }
      }

      // Thêm event listener cho scroll
      window.addEventListener('scroll', checkScroll);

      // Reset khi reload
      window.addEventListener('beforeunload', () => {
        sessionStorage.removeItem('cs-per-page');
        window.scrollTo(0, 0);
      });
    });
  </script>
<?php
  return ob_get_clean();
}
add_shortcode('sc_breakpoint_scroll', 'sc_breakpoint_scroll_shortcode');

// Phần xử lý query vẫn giữ nguyên
add_action('pre_get_posts', function ($query) {
  if (isset($_GET['cs-per-page'])) {
    $per_page = $_GET['cs-per-page'];
    $query->set('posts_per_page', $per_page);
  }
});

?>