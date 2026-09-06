<?php
if(function_exists('register_sidebar'))
{
  register_sidebar(array('name'=>'Right Sidebar','id'=>'right-sidebar'));
  register_sidebar(array('name'=>'Left Sidebar','id'=>'left-sidebar'));
  register_sidebar(array('name'=>'Page Bottom','id'=>'page-bottom'));
  register_sidebar(array('name'=>'Wide Bottom','id'=>'wide-bottom'));
  register_sidebar(array('name'=>'AdSenseLeader','id'=>'adsenseleader'));
  register_sidebar(array('name'=>'AdSenseRight','id'=>'adsenseright'));
  register_sidebar(array('name'=>'AdSenseInterpost','id'=>'adsenseinterpost'));
}

