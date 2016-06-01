<?php /* Smarty version Smarty-3.1.21, created on 2016-06-01 15:50:46
         compiled from "/var/www/html/design/backend/templates/common/comet.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2123658897574eda26b79e34-41118661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
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
  'nocache_hash' => '2123658897574eda26b79e34-41118661',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_574eda26b7dbd3_89426550',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_574eda26b7dbd3_89426550')) {function content_574eda26b7dbd3_89426550($_smarty_tpl) {?><?php
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
