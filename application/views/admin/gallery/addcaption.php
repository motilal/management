<?php $this->load->view('admin/template/header',$data);?>
 <h3 style="cursor: s-resize;">Manage Caption</h3>
<ul class="content-box-tabs-href">
  <li><a id="ttab1" href="<?php echo site_url().'admin/gallery';?>" class="default-tab ">Gallery</a></li>
  <li><a id="ttab2" href="#" class="default-tab current">Add Caption</a></li>
</ul>
<div class="clear"></div>
</div>

	<div class="content-box-content"> 
 	<?php gallery::showmessage(); ?>   
    <div style="display: block;" class="tab-content default-tab" id="tab2">   
	<form action="<?php echo site_url();?>admin/gallery/addcaption" method="post" class="block-content form" >
   <p class="inline-mini-label"> 
    <table width="1000" border="1" cellspacing="0" cellpadding="0" align="center" style="margin-top:10px">
    <tr>
    <td width="200" height="30" style="text-align:center; background:#F7F7F7;padding-left: 10px;"><strong>Image</strong></td>         
    <td width="578" style="text-align:center;background:#F7F7F7;padding-left: 10px;"><strong>Caption</strong></td>
    </tr>
	<?php foreach($caption as $album){?>
	 <tr>
          <td width="160" style="padding:9px 0px 9px 36px;" ><div class="img"> 
          <a class="fancybox-effects-a" rel="group" href="<?php echo site_url();?>media/gallery/<?php echo $album['photo_thumb_path']; ?>"> 
          <img src="<?php echo site_url();?>media/gallery/thumbnails/<?php echo $album['photo_thumb_path']; ?>" width="120" height="93" alt="image" />
          </a>
          </div></td>         
    <td width="578"  style="vertical-align:middle;"><strong>
	<input type="text" name="<?php echo $album['id'];?>"  value="<?php if($album['photo_caption']==""){echo "";}else{echo $album['photo_caption'];}?>" style="width:470px; " class="text-input"> </strong>
	 	
	</td>
	</tr>
	
	<?php }?>
	<tr><td  colspan="2" height="70" style="padding-left:200px; text-align:left;">
    		<input type="submit" value="Save"  class="button"  style="width:98px; height:33px; margin-left:10%;" />
            <input type="reset" value="Reset"  class="button red" id="savebrand"  style="margin-left:10px; height:33px;" />
	<a href="<?php echo site_url();?>/admin/gallery" style="text-decoration:none;"><input type="button" value="Go Back" class="button" style="margin-left:10px; height:33px;" ></a></td>
	 </tr>
	
           </table> 
		  
   </form>
  </p>  
   </div>

</div>
</div>   
<?php $this->load->view('admin/template/footer'); ?>

           
