<div id="loader-overlay">
  <div class="loader"></div>
</div>
<script>
window.onbeforeunload = function(event) { turnOffLoader(); };

function turnOnLoader() {
  document.getElementById("loader-overlay").style.display = "block";
  // setTimeout(function() { turnOffLoader(); }, 2000);
}

function turnOffLoader() {
  document.getElementById("loader-overlay").style.display = "none";
}

</script>
