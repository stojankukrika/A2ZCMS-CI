<?php
 
 /*
 * Icon Helper
 */
if ( ! function_exists('tbs_icon') )
{
 function tbs_icon ($icon, $white=false)
 {
  if($white)
  {
   return "<i class='icon-".$icon." icon-white'></i>";
  }
  else
  {
   return "<i class='icon-".$icon."'></i>";
  }
   
 }
}
 
/**
 * Form Open
 *
 * The same as "form_open()" from CI. For an easier usage.
 * You can use "form_open()" or "tbs_form_open" - just dont care.
 *
 * @access public
 * @param string  the URI segments of the form destination
 * @param array  a key/value pair of attributes
 * @param array  a key/value pair of hidden data
 * @return string
 */
if ( ! function_exists('tbs_form_open') )
{
 function tbs_form_open($action = '', $attributes = '', $hidden = array())
 {
  return form_open($action, $attributes, $hidden);
 }
}
 
/**
 * Form Actions
 *
 * @access public
 * @param string  the URI segments of the form destination
 * @param array  a key/value pair of attributes
 * @param array  a key/value pair of hidden data
 * @return string
 */
 
if ( ! function_exists('tbs_form_actions') )
{
    function tbs_form_actions($label, $icon, $white=true)
    {
        $input_tpl = tbs_form_actions_tpl();
         
  if($white!=false){
   $icon = "<i class='icon-".$icon." icon-white'></i>";
  }
        else
        {
            $icon = "<i class='icon-".$icon."'></i>";
        }
 
  $input_field = sprintf($input_tpl, $icon, $label);
 
  return $input_field;
    }
}
 
if ( !function_exists('tbs_form_actions_tpl'))
{
 function tbs_form_actions_tpl()
 {
   
  $input_tpl = '<div class="form-actions">                <button type="submit" class="btn btn-primary">%1$s %2$s</button>
   </div>';
 
  // $input_tpl .= '%5$s';
 
  return $input_tpl;
 }
}
 
 
// ============================================================================
 
 
/**
 * Horizontal Form Open
 *
 * Creates the opening portion of the form, adding the required CSS-Class "form-horizontal"
 *
 * @access public
 * @param string  action the URI segments of the form destination
 * @param array  attributes a key/value pair of attributes
 * @param array  hidden a key value pair of hidden data
 * @return string
 */
if ( ! function_exists('tbs_horizontal_form_open') )
{
 function tbs_horizontal_form_open($action = '', $attributes = array(), $hidden = array())
 {
  $attributes = _add_tbs_form_class($attributes, 'form-horizontal');
 
  $form = form_open($action, $attributes, $hidden);
 
  return $form;
 }
}
 
 
// ============================================================================
 
 
/**
 * Inline Form Open
 *
 * Creates the opening portion of the form, adding the required CSS-Class "form-inline"
 *
 * @access public
 * @param string  action the URI segments of the form destination
 * @param array  attributes a key/value pair of attributes
 * @param array  hidden a key value pair of hidden data
 * @return string
 */
if ( ! function_exists('tbs_inline_form_open') )
{
 function tbs_inline_form_open($action = '', $attributes = array(), $hidden = array())
 {
  $attributes = _add_tbs_form_class($attributes, 'form-inline');
 
  $form = form_open($action, $attributes, $hidden);
 
  return $form;
 }
}
 
 
// ============================================================================
 
 
/**
 * Search Form Open
 *
 * Creates the opening portion of the form, adding the required CSS-Class "form-search"
 *
 * @access public
 * @param string  action the URI segments of the form destination
 * @param array  attributes a key/value pair of attributes
 * @param array  hidden a key value pair of hidden data
 * @return string
 */
if ( ! function_exists('tbs_search_form_open') )
{
 function tbs_search_form_open($action = '', $attributes = array(), $hidden = array())
 {
  $attributes = _add_tbs_form_class($attributes, 'form-search');
 
  $form = form_open($action, $attributes, $hidden);
 
  return $form;
 }
}
 
 
// ============================================================================
 
 
/**
 * Form Close
 *
 * The same as "form_close()" from CI. For an easier usage.
 * You can use "form_close()" or "tbs_form_close()" - just don't care.
 *
 * @access public
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_close') )
{
 function tbs_form_close($extra = '')
 {
  return form_close($extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Fieldset Tag
 *
 * The same as "form_fieldset()" from CI. For an easier usage.
 * You can use "form_fieldset()" or "tbs_form_fieldset()" - just don't care.
 *
 * @access public
 * @param string
 * @param array
 * @return string
 */
if ( ! function_exists('tbs_form_fieldset') )
{
 function tbs_form_fieldset($legend_text = '', $attributes = array())
 {
  return form_fieldset($legend_text, $attributes);
 }
}
 
 
// ============================================================================
 
 
/**
 * Fieldset close tag
 *
 * The same as "form_fieldset_close()" from CI. For an easier usage.
 * You can use "form_fieldset_close()" or "tbs_form_fieldset_close()" - just don't care.
 *
 * @access public
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_fieldset_close') )
{
 function tbs_form_fieldset_close($extra = '')
 {
  return form_fieldset_close($extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Text Input Field
 * The same as "form_input()" from CI. For an easier usage.
 * You can use "form_input()" or "tbs_form_input" - just don't care.
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_input') )
{
 function tbs_form_input($data = '', $value = '', $extra = '')
 {
  return form_input($data, $value, $extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Password Field
 *
 * Identical to the Text Input Field but adds the "password" type
 * The same as "form_password()" from CI. For an easier usage.
 * You can use "form_password()" or "tbs_form_password" - just don't care.
 *
 * @param mixed
 * @param string
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_password') )
{
 function tbs_form_password($data = '', $value = '', $extra = '')
 {
  return form_password($data, $value, $extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Upload Field
 *
 * Identical to the Text Input Field but adds the "file" type
 * The same as "form_upload()" from CI. For an easier usage.
 * You can use "form_upload()" or "tbs_form_upload" - just don't care.
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_upload') )
{
 function tbs_form_upload($data = '', $value = '', $extra = '')
 {
  return form_upload($data, $value, $extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Textarea Field
 *
 * The same as "form_textarea()" from CI. For an easier usage.
 * You can use "form_textarea()" or "tbs_form_textarea" - just don't care.
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_textarea') )
{
 function tbs_form_textarea($data = '', $value = '', $extra = '')
 {
  return form_textarea($data, $value, $extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Checkbox Field
 *
 * Extends the checkbox field from CI with the necessary HTML-Markup for Twitter Bootstrap.
 * Added one parameter for the label. Otherwise use it the same way as form_checkbox()
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @param bool
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_checkbox') )
{
 function tbs_form_checkbox($data = '', $label = '', $value = '', $checked = FALSE, $extra = '')
 {
   
  $tpl = '<div class="controls"><label class="checkbox">'
     .'%1$s' // will be replaced by the input
     .'%2$s' // will be replaced by the label
    .'</label></div>';
 
  $input = form_checkbox($data, $value, $checked, $extra);
 
  return sprintf($tpl, $input, $label);
 }
}
 
 
// ============================================================================
 
 
/**
 * Radio Field
 *
 * Extends the radio field from CI with the necessary HTML-Markup for Twitter Bootstrap.
 * Added one parameter for the label. Otherwise use it the same way as form_radio()
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @param bool
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_radio') )
{
 function tbs_form_radio($data = '', $label = '', $value = '', $checked = FALSE, $extra = '')
 {
  $tpl = '<label class="radio">'
     .'%1$s' // will be replaced by the input
     .'%2$s' // will be replaced by the label
    .'</label>';
 
  $input = form_radio($data, $value, $checked, $extra);
 
  return sprintf($tpl, $input, $label);
 
 }
}
 
 
// ============================================================================
 
 
/**
 * Inline checkbox field
 *
 * The same as tbs_form_checkbox except it will be displayed inline
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @param bool
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_inline_form_checkbox') )
{
 function tbs_inline_form_checkbox($data = '', $label = '', $value = '', $checked = FALSE, $extra = '')
 {
  $tpl = '<label class="checkbox inline">'
     .'%1$s' // will be replaced by the input
     .'%2$s' // will be replaced by the label
    .'</label>';
 
  $input = form_checkbox($data, $value, $checked, $extra);
 
  return sprintf($tpl, $input, $label);
 }
}
 
 
// ============================================================================
 
 
/**
 * Inline radio field
 *
 * The same as tbs_form_radio execpt it will be display inline
 *
 * @access public
 * @param mixed
 * @param string
 * @param string
 * @param bool
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_inline_form_radio') )
{
 function tbs_inline_form_radio($data = '', $label = '', $value = '', $checked = FALSE, $extra = '')
 {
  $tpl = '<label class="radio inline">'
     .'%1$s' // will be replaced by the input
     .'%2$s' // will be replaced by the label
    .'</label>';
 
  $input = form_radio($data, $value, $checked, $extra);
 
  return sprintf($tpl, $input, $label);
 }
}
 
 
// ============================================================================
 
 
/**
 * Drop-down Menu
 *
 * The same as "form_dropdown()" from CI. For an easier usage.
 * You can use "form_dropdown()" or "tbs_form_dropdown" - just don't care.
 *
 * @access public
 * @param string
 * @param array
 * @param string
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_dropdown') )
{
 function tbs_form_dropdown($name = '', $options = array(), $selected = array(), $extra = '')
 {
  return form_dropdown($name, $options, $selected, $extra);
 }
}
 
 
// ============================================================================
 
 
/**
 * Multi-select menu
 *
 * The same as "form_multiselect()" from CI. For an easier usage.
 * You can use "form_multiselect()" or "tbs_form_multiselect" - just don't care.
 *
 * @access public
 * @param string
 * @param array
 * @param mixed
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_multiselect') )
{
 function tbs_form_multiselect($name = '', $options = array(), $selected = array(), $extra = '')
 {
  return form_multiselect($name, $options, $selected, $extra);
 }
}
 
 
// ============================================================================
 
 
// TODO: tbs_uneditable_input() - Needs some improvements for an easier handling of attributes
/**
 * Uneditable Input
 *
 * Presents data in a form that's not editable without using actual form markup
 *
 * @access public
 * @param string
 * @param string
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_uneditable_input') )
{
 function tbs_uneditable_input($text = '', $css_class = '', $extra = '')
 {
  $css_class = ($css_class != '') ? 'uneditable-input '.$css_class : 'uneditable-input';
  $extra = ($extra != '') ? ' ' . $extra : $extra;
  return '<span class="' . $css_class . '" '="" .="" $extra="">' . $text . '</span>';
 }
}
 
 
// ============================================================================
 
 
/**
 * Inline Help Text for a form element.
 * This have to be placed in a "bootstrap form opben", f.e. tbs_inline_form_open, tbs_horizontal_form_open, ...
 *
 * @access public
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_help_inline') )
{
 function tbs_form_help_inline($text = '')
 {
  return '<span class="help-inline">' . $text . '</span>';
 }
}
 
 
// ============================================================================
 
 
/**
 * Block Help Text for a form element.
 * This have to be placed in a "bootstrap form opben", f.e. tbs_inline_form_open, tbs_horizontal_form_open, ...
 *
 * @access public
 * @param string
 * @return string
 */
if ( ! function_exists('tbs_form_help_block') )
{
 function tbs_form_help_block($text = '')
 {
  return '<span class="help-block">' . $text . '</span>';
 }
}
 
 
// TODO: If the attributes is a string containing 'class="xyz"' - add the CSS-class 'form-horizontal' with some regex-magic if possible
/**
 * Add required CSS-class for form open
 *
 * Helper function used by some of the form helpers
 */
if ( ! function_exists('_add_tbs_form_class'))
{
 function _add_tbs_form_class($attributes, $css_class)
 {
  if ( is_array($attributes) AND count($attributes) > 0 )
  {
   if( array_key_exists('class', $attributes) )
   {
    $attributes['class'] .= ' ' . $css_class;
   }
   else
   {
    $attributes['class'] = $css_class;
   }
 
  }
  elseif ( is_array($attributes) AND count($attributes) == 0 )
  {
   $attributes['class'] = $css_class;
  }
  else
  {
   return false;
  }
 
  return $attributes;
 }
}
 
 
// ------------------------------------------------------------------------
 
 
/**
 * !!!!! Deprecated
 *
 * Generates the HTML for a Twitter Bootstrap Horizontal Input
 *
 * @var string
 * @author Markus Schober
 **/
if ( !function_exists('tbs_horizontal_input'))
{
 function tbs_horizontal_input($input_data, $labels, $required=false)
 {
 
  $input_tpl = tbs_horizontal_input_tpl();
 
  $error = (form_error($input_data['name'])) ? ' error' : '';
  $input_id = $input_data['id'];
  $input = form_input($input_data);
 
  if($required!=false){
   $label = "*";
  }
        else
            $label="";
 
  $input_field = sprintf($input_tpl, $error, $input_id, $labels['label'], $input, $labels['desc'], $label);
 
  return $input_field;
 }
}
 
/**
 * !!!!! Deprecated
 *
 * Generates the HTML for a Twitter Bootstrap Horizontal Input Password
 *
 * @var string
 * @author Markus Schober
 **/
if ( !function_exists('tbs_horizontal_password'))
{
 function tbs_horizontal_password($input_data, $labels, $required=false)
 {
 
  $input_tpl = tbs_horizontal_input_tpl();
 
  $error = (form_error($input_data['name'])) ? ' error' : '';
  $input_id = $input_data['id'];
  $input = form_password($input_data);
 
  if($required!=false){
   $label = "*";
  }
 
  $input_field = sprintf($input_tpl, $error, $input_id, $labels['label'], $input, $labels['desc'], $label);
 
  return $input_field;
 }
}
 
 
// ------------------------------------------------------------------------
 
 
/**
 * !!!!! Deprecated
 *
 * Generates the HTML for a Twitter Bootstrap Horizontal Textarea
 */
if ( !function_exists('tbs_horizontal_textarea'))
{
 function tbs_horizontal_textarea($input_data, $labels, $required=false)
 {
  $input_tpl = tbs_horizontal_input_tpl();
 
  $error = (form_error($input_data['name'])) ? ' error' : '';
  $input_id = $input_data['id'];
  $input = form_textarea($input_data);
 
 
  if($required!=false){
   $label = "*";
  }
 
  $input_field = sprintf($input_tpl, $error, $input_id, $labels['label'], $input, $labels['desc'], $label);
 
  return $input_field;
 }
}
 
 
// ------------------------------------------------------------------------
 
 
/**
 * !!!!! Deprecated
 */
if ( !function_exists('tbs_horizontal_dropdown'))
{
 function tbs_horizontal_dropdown($name, $options, $selected, $additional_data, $labels)
 {
 
  $input_tpl = tbs_horizontal_input_tpl();
 
  $error = (form_error($name)) ? ' error' : '';
  $input_id = $additional_data['id'];
  $additional_data = 'id="' . $additional_data['id'] . '" class="' . $additional_data['class'] . '"';
  $input = form_dropdown($name, $options, $selected, $additional_data);
 
  $input_field = sprintf($input_tpl, $error, $input_id, $labels['label'], $input, $labels['desc']);
 
  return $input_field;
 
 }
}
 
 
// ------------------------------------------------------------------------
 
 
/**
 * !!!!! Deprecated
 *
 * Helper function for the standard template for
 * <input> Elements for Twitter Bootstrap 2.0
 *
 * @var string
 **/
if ( !function_exists('tbs_horizontal_input_tpl'))
{
 function tbs_horizontal_input_tpl()
 {
   
  $input_tpl = '<div class="control-group%1$s">   <label class="control-label" for="%2$s">%3$s %6$s</label>
   <div class="controls">    %4$s
    <span class="help-inline">%5$s</span>
   </div>   </div>';
 
  // $input_tpl .= '%5$s';
 
  return $input_tpl;
 }
}
 
 
 
//End of file MY_form_helper.php