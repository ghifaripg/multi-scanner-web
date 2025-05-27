<div id="loadingOverlay" style="display: none;">
  <div class="overlay-bg">
    <div class="overlay-content text-center">
      <div class="spinner-grow text-light" role="status"></div>
      <p class="text-light mt-3 fs-5">Scanning...</p>
    </div>
  </div>
</div>

<style>
  #loadingOverlay .overlay-bg {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background-color: rgba(0, 0, 0, 0.6); 
    z-index: 1055;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  #loadingOverlay .overlay-content {
    text-align: center;
  }
</style>

<script>
  function showLoadingOverlay() {
    document.getElementById('loadingOverlay').style.display = 'block';
  }

  function hideLoadingOverlay() {
    document.getElementById('loadingOverlay').style.display = 'none';
  }
</script>
