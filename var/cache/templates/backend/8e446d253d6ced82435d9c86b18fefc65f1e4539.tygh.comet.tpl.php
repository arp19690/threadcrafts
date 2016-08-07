<?php /* Smarty version Smarty-3.1.21, created on 2016-07-28 02:11:31
         compiled from "/var/www/html/design/backend/templates/common/comet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:198298393057991c7bc98a29-68206541%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8e446d253d6ced82435d9c86b18fefc65f1e4539' => 
    array (
      0 => '/var/www/html/design/backend/templates/common/comet.tpl',
      1 => 1450182318,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '198298393057991c7bc98a29-68206541',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_57991c7bc9c259_34069488',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_57991c7bc9c259_34069488')) {function content_57991c7bc9c259_34069488($_smarty_tpl) {?><?php
fn_preload_lang_vars(array('processing'));
?>
<a id="comet_container_controller" data-backdrop="static" data-keyboard="false" href="#comet_control" data-toggle="modal" class="hide"></a>

<div class="modal hide fade" id="comet_control" tabindex="-1" role="dialog" aria-labelledby="comet_title" aria-hidden="true">
    <div class="modal-header">
        <h3 id="comet_title"><?php echo $_smarty_tpl->__("processing");?>
</h3>
    </div>
    <div class="modal-body">
        <p></p>
        <div class="progress progress-striped active">
            
            <div class="bar" style="width: 0%;"></div>
        </div>
    </div>
</div><?php }} ?>
