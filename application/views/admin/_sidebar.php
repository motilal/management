<?php
$segment_cntr = $this->uri->segment(2);
$segment_fun = $this->uri->segment(3);

$pageIndex = ($segment_cntr == 'pages' && ($segment_fun == 'index' || $segment_fun == '')) ? 'active' : '';
$pageAdd = ($segment_cntr == 'pages' && $segment_fun == 'manage') ? 'active' : '';

$eventIndex = ($segment_cntr == 'events' && ($segment_fun == 'index' || $segment_fun == '')) ? 'active' : '';
$eventAdd = ($segment_cntr == 'events' && $segment_fun == 'manage') ? 'active' : '';
$eventCal  = ($segment_cntr == 'events' && $segment_fun == 'calendar') ? 'active' : '';

$countryIndex = ($segment_cntr == 'countries' && ($segment_fun == 'index' || $segment_fun == '')) ? 'active' : '';
$countryAdd = ($segment_cntr == 'countries' && $segment_fun == 'manage') ? 'active' : '';

$stateIndex = ($segment_cntr == 'states' && ($segment_fun == 'index' || $segment_fun == '')) ? 'active' : '';
$stateAdd = ($segment_cntr == 'states' && $segment_fun == 'manage') ? 'active' : '';

$cityIndex = ($segment_cntr == 'cities' && ($segment_fun == 'index' || $segment_fun == '')) ? 'active' : '';
$cityAdd = ($segment_cntr == 'cities' && $segment_fun == 'manage') ? 'active' : '';

$settingIndex = ($segment_cntr == 'settings' && ($segment_fun == 'index' || $segment_fun == '')) ? 'active' : '';
$settingProfile = ($segment_cntr == 'settings' && $segment_fun == 'profile') ? 'active' : '';
?>
<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" id="side-menu">

            <li>
                <a href="<?php echo site_url('admin/dashboard'); ?>" class="<?php echo $segment_cntr == 'dashboard' ? 'active' : ''; ?>"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
            </li>  

            <li class="<?php echo $segment_cntr == 'pages' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-files-o fa-fw"></i> Static Pages<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level <?php echo $segment_cntr == 'pages' ? 'in' : ''; ?>">
                    <li>
                        <a href="<?php echo site_url('admin/pages/index'); ?>" class="<?php echo $pageIndex; ?>">Page List</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/pages/manage'); ?>" class="<?php echo $pageAdd; ?>">Add Page</a>
                    </li> 
                </ul> 
            </li>
            
            <li class="<?php echo $segment_cntr == 'events' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-calendar"></i> Events <span class="fa arrow"></span></a>
                <ul class="nav nav-second-level <?php echo $segment_cntr == 'events' ? 'in' : ''; ?>">
                    <li>
                        <a href="<?php echo site_url('admin/events/index'); ?>" class="<?php echo $eventIndex; ?>">Event List</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/events/manage'); ?>" class="<?php echo $eventAdd; ?>">Add Event</a>
                    </li> 
                    <li>
                        <a href="<?php echo site_url('admin/events/calendar'); ?>" class="<?php echo $eventCal; ?>">Calendar</a>
                    </li> 
                </ul> 
            </li>
            
            <li class="<?php echo in_array($segment_cntr, array('countries', 'states', 'cities')) ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-globe fa-fw"></i> Locations<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level <?php echo in_array($segment_cntr, array('countries', 'states', 'cities')) ? 'in' : ''; ?>">
                    <li class="<?php echo $segment_cntr == 'countries' ? 'active' : ''; ?>">
                        <a href="#">Country <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level <?php echo $segment_cntr == 'countries' ? 'in' : ''; ?>">
                            <li>
                                <a href="<?php echo site_url('admin/countries/index'); ?>" class="<?php echo $countryIndex; ?>">Country List</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/countries/manage'); ?>" class="<?php echo $countryAdd; ?>">Add Country</a>
                            </li>
                        </ul> 
                    </li> 
                    <li class="<?php echo $segment_cntr == 'states' ? 'active' : ''; ?>">
                        <a href="#">State <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level <?php echo $segment_cntr == 'states' ? 'in' : ''; ?>">
                            <li>
                                <a href="<?php echo site_url('admin/states/index'); ?>" class="<?php echo $stateIndex; ?>">State List</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/states/manage'); ?>" class="<?php echo $stateAdd; ?>">Add State</a>
                            </li>
                        </ul> 
                    </li> 
                    <li class="<?php echo $segment_cntr == 'cities' ? 'active' : ''; ?>">
                        <a href="#">City <span class="fa arrow"></span></a>
                        <ul class="nav nav-third-level <?php echo $segment_cntr == 'cities' ? 'in' : ''; ?>">
                            <li>
                                <a href="<?php echo site_url('admin/cities/index'); ?>" class="<?php echo $cityIndex; ?>">City List</a>
                            </li>
                            <li>
                                <a href="<?php echo site_url('admin/cities/manage'); ?>" class="<?php echo $cityAdd; ?>">Add City</a>
                            </li>
                        </ul> 
                    </li> 
                </ul> 
            </li>

            <li>
                <a href="<?php echo site_url('admin/galleries'); ?>" class="<?php echo $segment_cntr == 'galleries' ? 'active' : ''; ?>"><i class="fa fa-image fa-fw"></i> Gallery</a>
            </li> 

            <li>
                <a href="<?php echo site_url('admin/email_templates'); ?>" class="<?php echo $segment_cntr == 'email_templates' ? 'active' : ''; ?>"><i class="fa fa-envelope-o fa-fw"></i> Email Templates</a>
            </li> 

            <li class="<?php echo $segment_cntr == 'settings' ? 'active' : ''; ?>">
                <a href="#"><i class="fa fa-wrench fa-fw"></i> Site Setting<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level <?php echo $segment_cntr == 'settings' ? 'in' : ''; ?>">
                    <li>
                        <a href="<?php echo site_url('admin/settings/profile'); ?>" class="<?php echo $settingProfile ?>">Profile Setup</a>
                    </li>
                    <li>
                        <a href="<?php echo site_url('admin/settings/index'); ?>" class="<?php echo $settingIndex ?>">Settings</a>
                    </li> 
                </ul>
                <!-- /.nav-second-level -->
            </li>

        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>