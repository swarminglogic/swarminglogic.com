<?php
if(isset($pageWrapperDiv)) {
  echo '        </div>
';
}
?>
	</div><!-- container -->
</div> <!-- wrapper -->
	<script src="/javascripts/jquery-1.10.1.min.js"></script>
	<script src="/javascripts/scrollspy.js"></script>
	<script src="/javascripts/custom.js"></script>
<?php
if (file_exists('analytics-footer')) {
  include 'analytics-footer';
}
?>
</body>
</html>
