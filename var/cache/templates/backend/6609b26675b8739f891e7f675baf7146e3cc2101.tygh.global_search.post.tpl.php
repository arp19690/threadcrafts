<?php /* Smarty version Smarty-3.1.21, created on 2016-06-01 15:50:46
         compiled from "/var/www/html/design/backend/templates/addons/twigmo/hooks/index/global_search.post.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1837722329574eda26a79710-57116159%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6609b26675b8739f891e7f675baf7146e3cc2101' => 
    array (
      0 => '/var/www/html/design/backend/templates/addons/twigmo/hooks/index/global_search.post.tpl',
      1 => 1450182322,
      2 => 'tygh',
    ),
  ),
  'nocache_hash' => '1837722329574eda26a79710-57116159',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'runtime' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.21',
  'unifunc' => 'content_574eda26a842d1_98828122',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_574eda26a842d1_98828122')) {function content_574eda26a842d1_98828122($_smarty_tpl) {?><?php if (!is_callable('smarty_block_inline_script')) include '/var/www/html/app/functions/smarty_plugins/block.inline_script.php';
?><?php
fn_preload_lang_vars(array('twgadmin_mobile_app'));
?>
<?php if ($_smarty_tpl->tpl_vars['runtime']->value['twigmo']['admin_connection']['access_id']) {?>

    <div class="twg-mobile-app-link">
        <a href="<?php echo htmlspecialchars(fn_url("twigmo_admin_app.view"), ENT_QUOTES, 'UTF-8');?>
"><?php echo $_smarty_tpl->__("twgadmin_mobile_app");?>
</a>
    </div>

    <?php $_smarty_tpl->smarty->_tag_stack[] = array('inline_script', array()); $_block_repeat=true; echo smarty_block_inline_script(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>
<?php echo '<script'; ?>
 type="text/javascript">
        (function(_, $) {
            $(document).ready(function() {
                $('div.twg-mobile-app-link').detach().insertBefore('ul.nav.hover-show.nav-pills').show();
            });
        }(Tygh, Tygh.$));
    <?php echo '</script'; ?>
><?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_block_inline_script(array(), $_block_content, $_smarty_tpl, $_block_repeat);  } array_pop($_smarty_tpl->smarty->_tag_stack);?>


<?php }?><?php }} ?>
