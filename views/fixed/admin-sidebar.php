<div class="sidebar" data-color="purple" data-background-color="white" data-image="../assets/img/sidebar-1.jpg">
      <!--
        Tip 1: You can change the color of the sidebar using: data-color="purple | azure | green | orange | danger"

        Tip 2: you can also add an image using data-image tag
    -->
      <div class="logo"><a class="simple-text logo-normal">
          Admin Panel
        </a></div>
      <div class="sidebar-wrapper ps-container ps-theme-default" data-ps-id="e6717b88-a981-a93e-667e-6457e4473953">
        <ul class="nav">
          <li class="nav-item <?php if($_GET["page"] == "admin-dashboard")  echo("active") ?> ">
            <a class="nav-link" href="index.php?page=admin-dashboard">
            <i class="fas fa-chart-bar"></i>
              <p>Dashboard</p>
            </a>
          </li>
          <li class="nav-item <?php if($_GET["page"]  == "admin-reports")  echo("active") ?> ">
            <a class="nav-link" href="index.php?page=admin-reports">
              <i class="fas fa-file-alt"></i>
              <p>Reports</p>
            </a>
          </li>
          <li class="nav-item <?php if($_GET["page"]  == "content-manipulation")  echo("active") ?>">
            <a class="nav-link" href="index.php?page=content-manipulation">
              <i class="fas fa-edit"></i>
              <p>Content Manipulation</p>
            </a>
          </li>
        </ul>
      <!-- <div class="ps-scrollbar-x-rail" style="left: 0px; bottom: 0px;"><div class="ps-scrollbar-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps-scrollbar-y-rail" style="top: 0px; right: 0px;"><div class="ps-scrollbar-y" tabindex="0" style="top: 0px; height: 0px;"></div></div></div>
    <div class="sidebar-background" style="background-image: url(../assets/img/sidebar-1.jpg) "></div></div> -->
    </div></div>