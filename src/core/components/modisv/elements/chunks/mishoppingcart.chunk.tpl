<table class="shopping_cart">
    <tr>
        <th>Item Details</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Sub-Total</th>
        <th></th>
    </tr>
    [[+wrapper]]
    [[!If? &subject=`[[+coupon_discount]]` &operator=`>` &operand=`0` &then=`
    <tr>
        <td class="item highlight" colspan="3">[[+coupon_name]]</td>
        <td class="sub_total highlight" colspan="2">-$[[+coupon_discount]]</td>
    </tr>
    `]]
    <tr>
        <td colspan="5">
            <a href="#" onclick="$(this).next('form').toggle(); return false;"><span>I have a coupon code</span></a>
            <form id="coupon_form" action="[[+coupon_url]]" method="post">
                <dl>
                    <dt><label for="coupon_code">Please enter it here:</label></dt>
                    <dd>
                        <input id="coupon_code" type="text" name="coupon_code" value="[[+coupon_code]]" />
                        <input type="hidden" name="action" value="coupon" />
                        <input type="submit" value="Apply" title="Apply the coupon code" />
                        <span class="error">[[+error.coupon_code]]</span>
                    </dd>
                </dl>
            </form>
        </td>
    </tr>
    <tr>
        <td colspan="2"></td>
        <td class="total"><strong>Total:</strong></td>
        <td colspan="2">$[[+total]]</td>
    </tr>
    <tr>
        <td colspan="5">
            <a href="[[+checkout_url]]" title="Checkout with Paypal" class="checkout_btn paypal" ></a>
        </td>
    </tr>
</table>
