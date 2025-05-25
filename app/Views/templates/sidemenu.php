
<div id="mySidebar" class="sidebar">
    <button class="openbtn" onclick="openNav()">
        <i class="fa fa-burger-menu"></i>
    </button> 
        <a href="javascript:void(50px)" class="closebtn" onclick="closeNav()">
          <i class="fa fa-close"></i>
        </a>
        <ul>
          <li>
            <a href="#"><i class="fa fa-home"></i> Home</a>
          </li>  
          <li>
            <a href="#"><i class="fa fa-home"></i> Notification</a>
          </li>   
          <li>
            <a href="#"><i class="fa fa-home"></i> History</a>
          </li> 
          <li>
            <a href="#"><i class="fa fa-home"></i> Profile</a>
          </li>  
          <li>  
            <a href="#"><i class="fa fa-home"></i> Settings</a>
          </li>  
        </ul>
</div>


<script>
function openNav() {
  document.getElementById("mySidebar").style.width = "250px";
}

function closeNav() {
  document.getElementById("mySidebar").style.width = "50px";
}
</script>