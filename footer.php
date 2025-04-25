<footer class="footer fade-in">
    <div class="container">
      <div class="footer-content">
        <div class="footer-section">
          <h3>StoryCollab</h3>
          <p>A collaborative platform for writers to create and share stories together.</p>
        </div>
        <div class="footer-section">
          <h3>Quick Links</h3>
          <ul>
            <li><a href="index.html">Home</a></li>
            <li><a href="stories.php">Explore Stories</a></li>
            <li><a href="register.php">Join Now</a></li>
          </ul>
        </div>
        <div class="footer-section">
          <h3>Connect With Us</h3>
          <div class="social-icons">
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-twitter"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 StoryCollab. All rights reserved.</p>
      </div>
    </div>
  </footer>
  <script>
    $(document).ready(function() {
      // Animate elements when they come into view
      $(window).scroll(function() {
        $('.fade-in').each(function() {
          let bottom_of_element = $(this).offset().top + $(this).outerHeight() / 2;
          let bottom_of_window = $(window).scrollTop() + $(window).height();
          
          if (bottom_of_window > bottom_of_element) {
            $(this).addClass('visible');
          }
        });
      });
      $(window).scroll();
    });
  </script>
</body>
</html>
