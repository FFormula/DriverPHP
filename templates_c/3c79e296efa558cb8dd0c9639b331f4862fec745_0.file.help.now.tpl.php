<?php
/* Smarty version 3.1.30, created on 2016-11-04 14:54:43
  from "G:\php-debug-demo\templates\help.now.tpl" */

/* @var Smarty_Internal_Template $_smarty_tpl */
if ($_smarty_tpl->_decodeProperties($_smarty_tpl, array (
  'version' => '3.1.30',
  'unifunc' => 'content_581c77038973c2_82020550',
  'has_nocache_code' => false,
  'file_dependency' => 
  array (
    '3c79e296efa558cb8dd0c9639b331f4862fec745' => 
    array (
      0 => 'G:\\php-debug-demo\\templates\\help.now.tpl',
      1 => 1478260476,
      2 => 'file',
    ),
  ),
  'includes' => 
  array (
    'file:head.tpl' => 1,
    'file:tail.tpl' => 1,
  ),
),false)) {
function content_581c77038973c2_82020550 (Smarty_Internal_Template $_smarty_tpl) {
$_smarty_tpl->_subTemplateRender("file:head.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
?>


<h2>Help</h2>

<pre>
    Server time: <?php echo $_smarty_tpl->tpl_vars['php']->value['now'];?>

</pre>

<?php $_smarty_tpl->_subTemplateRender("file:tail.tpl", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, 0, $_smarty_tpl->cache_lifetime, array(), 0, false);
}
}
