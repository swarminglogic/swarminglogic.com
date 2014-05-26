<?php
if(isset($pageWrapperDiv)) {
  echo '        </div>
';
}
?>
	</div><!-- container -->
</div> <!-- wrapper -->
	<script src="/javascripts/jquery-1.11.0.min.js"></script>
	<script src="/javascripts/lightbox.min.js"></script>
	<script src="/javascripts/scrollspy.js"></script>
	<script src="/javascripts/custom.js"></script>
<?php
if (file_exists('analytics-footer')) {
  include 'analytics-footer';
}
?>
</body>
</html>
