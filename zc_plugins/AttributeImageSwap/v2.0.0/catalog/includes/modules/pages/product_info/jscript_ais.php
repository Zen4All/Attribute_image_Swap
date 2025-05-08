<?php
//
// +----------------------------------------------------------------------+
// |zen-cart Open Source E-commerce                                       |
// +----------------------------------------------------------------------+
// | Copyright (c) 2003 The zen-cart developers                           |
// |                                                                      |
// | http://www.zen-cart.com/index.php                                    |
// |                                                                      |
// | Portions Copyright (c) 2003 osCommerce                               |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.0 of the GPL license,       |
// | that is bundled with this package in the file LICENSE, and is        |
// | available through the world-wide-web at the following url:           |
// | http://www.zen-cart.com/license/2_0.txt.                             |
// | If you did not receive a copy of the zen-cart license and are unable |
// | to obtain it through the world-wide-web, please send a note to       |
// | license@zen-cart.com so we can mail you a copy immediately.          |
// +----------------------------------------------------------------------+
// $Id: jscript_ais.php,v 1.1 2016/10/17 21:50:47 tbowen Exp $ mc12345678 2016-12-14
//
?>
<script>
<?php if (ATTRIBUTES_ENABLED_IMAGES == 'true') { ?>
window.addEventListener('DOMContentLoaded', () => {
    const origImage = $('#productMainImage').html();
    function getattribimage(attribfield, width, height, products_options_values_id, products_id) {
console.log('hllo');
      zcJS.ajax({
        url: 'ajax.php?act=ajaxAttribImageSwap&method=swap_image',
        data: {
          'width': width,
          'height': height,
          'products_options_values_id': products_options_values_id,
          'products_id': products_id
        }
      }).done(function (resultArray) {
        console.log(resultArray);
        let product_color_image = resultArray.image_link;
        if (product_color_image !== "") {
          $('#productMainImage').html(product_color_image);
        } else {
          $('#productMainImage').html(origImage); // Return to original image.
        }
  <?php
  if (defined('ZEN_COLORBOX_STATUS') && ZEN_COLORBOX_STATUS == 'true') {
    require DIR_FS_CATALOG . DIR_WS_CLASSES . 'zen_colorbox/autoload_default.php';
  }
  ?>
      });
    }
});
<?php } ?>
  function ais_init() {
    let n = document.forms.length;

<?php
// Has attributes, and at least one of the option names has a setting of 6 or 8 and an image
$ais_support = defined('ATTRIBUTES_ENABLED_IMAGES') && ATTRIBUTES_ENABLED_IMAGES == 'true' && isset($_GET['products_id']) && $_GET['products_id'] != '' && zen_has_product_attributes((int)$_GET['products_id']);

if ($ais_support) {
//  zc_dump($ais_support);
  $sql = "SELECT COUNT(*) AS quantity
          FROM " . TABLE_PRODUCTS_OPTIONS . " popt,
               " . TABLE_PRODUCTS_ATTRIBUTES . " patrib
          WHERE patrib.products_id = " . (int)$_GET['products_id'] . "
          AND patrib.options_id = popt.products_options_id
          AND popt.language_id = " . (int)$_SESSION['languages_id'] . "
          AND (popt.products_options_images_style = 6
            OR popt.products_options_images_style = 8
          )
          LIMIT 1";
  $has_ais = $db->Execute($sql);
//  zc_dump($has_ais);
  $ais_support = $has_ais->fields['quantity'] > 0;
  ?>
      let theForm = false;

      for (let i = 0; i < n; i++) {
        if (document.forms[i].name == "cart_quantity") {
          theForm = document.forms[i];
          break;
        }
      }

      if (theForm) {
        n = theForm.elements.length;
        for (i = 0; i < n; i++) {
          if (theForm.elements[i].name == 'cart_quantity') {
            continue;
          }
          switch (theForm.elements[i].type) {
            case "select":
            case "select-one":
              try {
//			  console.log(theForm.elements[i]);
                theForm.elements[i].onchange();
              } catch (err) {
                // Action not associated with element.
              }
              break;
            case "text":
              try {
                theForm.elements[i].onkeyup();
              } catch (err) {
                // Action not associated with element.
              }
              break;
            case "checkbox":
            case "radio":
              if (document.getElementById(theForm.elements[i].id).checked) {
                try {
                  theForm.elements[i].onclick();
                } catch (err) {
                  // Action not associated with element.
                }
              }
              break;
            case "number":
              try {
                theForm.elements[i].onchange();
              } catch (err) {
                // Action not associated with element.
              }
              try {
                theForm.elements[i].onkeyup();
              } catch (err) {
                // Action not associated with element.
              }
              try {
                theForm.elements[i].oninput();
              } catch (err) {
                // Action not associated with element.
              }
              break;
          }
        }
      }
<?php } ?>
  };
  window.addEventListener('load', function () {
    ais_init();
  });
</script>
