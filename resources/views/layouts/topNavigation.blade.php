<div class="top-navigation" style="display:flex;justify-content:space-between;align-items:center;background-color:white;z-index:4;">
    <a href="/">
        <img src="/images/home_icon.png" width="45" height="45" />
    </a>
    <h4 style="color:#222;">{{$pageTitle}}</h4>
    <a href="#" onclick="back()">
        <img src="/images/back_icon.png" width="12" height="22" />
    </a>
</div>
<script>
function back() {
    event.preventDefault();
    @if(isset($backUrl) && $backUrl != null)
        window.location.href = "{{$backUrl}}";
    @else
        window.history.back();
    @endif

}
</script>
