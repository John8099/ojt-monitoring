<div class="col-md-3 left_col menu_fixed" style="transition:.5s">
    <div class="navbar nav_title" style="overflow: hidden; padding-bottom:1px">
        <a class="site_title">
            <img src="../images/CHSMSC.gif" alt="OJT Monitoring" style="width: 40px;">
            <span>OJT Monitoring</span>
        </a>
    </div>

    <div class="clearfix"></div>

    <!-- sidebar menu -->
    <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
        <div class="menu_section">
            <ul class="nav side-menu">
                <?php
                require_once('links.php');
                $counter = 0;
                foreach ($student_links as $desc => $link) {
                    echo "
                                <li><a href='" . $link . "'><i class='" . $student_icons[$counter] . "'></i> " . $desc . " </a></li>
                                ";
                    $counter++;
                }
                ?>
            </ul>
        </div>
    </div>
    <!-- /sidebar menu -->
</div>
<!-- top navigation -->
<div class="top_nav ." style="transition:.5s">
    <div class="nav_menu">
        <nav>
            <div class="nav toggle">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
            </div>

            <ul class="nav navbar-nav navbar-right">
                <li class="">
                    <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false" style="text-transform: capitalize;">
                        <img src="../images/avatar.png" alt="">
                        <?php echo "$user->fname " . $user->mname[0] . ". $user->lname"; ?>
                        <span class=" fa fa-angle-down"></span>
                    </a>
                    <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="../actions/logout.php" onclick="return confirm('Are you sure you want to Logout?')"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>

            </ul>
        </nav>
    </div>
</div>
<!-- /top navigation -->