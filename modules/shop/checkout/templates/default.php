<?php

/*

type: layout

name: Default

description: Default cart template

*/

?>

    <script>

        complete_order = window.complete_order || function () {

                mw.cart.checkout('#checkout_form_<?php print $params['id'] ?>', function () {

                    mw.$('.mw-checkout-form').hide();
                    mw.$('.mw-checkout-responce').html(this);


                });

            }

    </script>
<?php if ($requires_registration and is_logged() == false): ?>
    <module type="users/register"/>
<?php else: ?>

    <?php if ($payment_success == false): ?>

        <form class="mw-checkout-form" id="checkout_form_<?php print $params['id'] ?>" method="post"
              action="<?php print api_link('checkout') ?>">

            <?php $cart_show_enanbled = get_option('data-show-cart', $params['id']); ?>
            <?php if ($cart_show_enanbled != 'n'): ?>
                <module type="shop/cart" template="big" id="cart_checkout_<?php print $params['id'] ?>"
                        data-checkout-link-enabled="n"/>
            <?php endif; ?>


            <div class="mw-ui-row shipping-and-payment">
                <div class="mw-ui-col" style="width: 33%;">
                    <div class="mw-ui-col-container">
                        <div class="well">
                            <?php $user = get_user(); ?>
                            <h2 style="margin-top:0 " class="edit nodrop" field="checkout_personal_inforomation_title"
                                rel="global" rel_id="<?php print $params['id'] ?>"><?php _lang("Personal Information", "templates/liteness"); ?></h2>
                            <hr/>
                            <label>
                                <?php _lang("First Name", "templates/liteness"); ?>
                            </label>
                            <input name="first_name" class="field-full form-control" type="text"
                                   value="<?php if (isset($user['first_name'])) {
                                       print $user['first_name'];
                                   } ?>"/>
                            <label>
                                <?php _lang("Last Name", "templates/liteness"); ?>
                            </label>
                            <input name="last_name" class="field-full form-control" type="text"
                                   value="<?php if (isset($user['last_name'])) {
                                       print $user['last_name'];
                                   } ?>"/>
                            <label>
                                <?php _lang("Email", "templates/liteness"); ?>
                            </label>
                            <input name="email" class="field-full form-control" type="text"
                                   value="<?php if (isset($user['email'])) {
                                       print $user['email'];
                                   } ?>"/>
                            <label>
                                <?php _lang("Phone", "templates/liteness"); ?>
                            </label>
                            <input name="phone" class="field-full form-control" type="text"
                                   value="<?php if (isset($user['phone'])) {
                                       print $user['phone'];
                                   } ?>"/>
                        </div>
                    </div>
                </div>
                <?php if ($cart_show_shipping != 'n'): ?>
                    <div class="mw-ui-col">
                        <div class="mw-ui-col-container">
                            <module type="shop/shipping"/>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ($cart_show_payments != 'n'): ?>

                    <div class="mw-ui-col">
                        <div class="mw-ui-col-container">
                            <module type="shop/payments"/>
                        </div>
                    </div>
                <?php endif; ?>

            </div>
            <div class="alert hide"></div>
            <div class="mw-cart-action-holder">

                <module type="shop/checkout/terms"/>

                <br/>
                <?php $shop_page = get_content('is_shop=0'); ?>

                <?php if (is_array($shop_page)): ?>
                    <a href="<?php print page_link($shop_page[0]['id']); ?>"
                       class="btn btn-default"
                       type="button"><?php _lang("Continue Shopping", "templates/liteness"); ?></a>
                <?php endif; ?>

                <button class="btn btn-warning mw-checkout-btn"
                        onclick="complete_order();"
                        type="button" id="complete_order_button" <?php if ($tems): ?> disabled="disabled"   <?php endif; ?> >
                    <?php _lang("Complete order", "templates/liteness"); ?>
                </button>

            </div>
            <?php if (is_module('shop/coupons')): ?>

                <?php

                /* <ahref="javascript:mw.tools.open_module_modal('shop/coupons')"><?php _lang("Discounts", "templates/liteness"); ?></a>*/


                ?>

                <a href="javascript:$('#mw-checkout-discounts-holder').toggle();"><?php _lang("Discounts", "templates/liteness"); ?></a>
                <div id="mw-checkout-discounts-holder" style="display: none">
                    <module type="shop/coupons" id="discounts-<?php print $params['id'] ?>"/>
                </div>

            <?php endif; ?>
        </form>
        <div class="mw-checkout-responce"></div>
    <?php else: ?>
        <h2><?php _lang("Your payment was successfull.", "templates/liteness"); ?></h2>
    <?php endif; ?>
<?php endif; ?>