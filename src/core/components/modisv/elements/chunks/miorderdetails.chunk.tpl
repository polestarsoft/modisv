<h3>Order #[[+guid]]</h3>
<table class="orders hgrid">
    <tr>
        <th>Item</th>
        <th>Unit Price</th>
        <th>Qty</th>
        <th>Sub-Total</th>
    </tr>
    [[+wrapper]]
    [[!If? &subject=`[[+discount]]` &operator=`>` &operand=`0` &then=`
    <tr class="discount">
        <td class="item">[[+coupon]]</td>
        <td class="unit_price"></td>
        <td class="quantity"></td>
        <td class="total">-$[[+discount]]</td>
    </tr>
    `]]
    <tr class="total">
        <td colspan="2"></td>
        <td>Total:</td>
        <td>$[[+total]]</td>
    </tr>
</table>
