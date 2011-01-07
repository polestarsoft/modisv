<div class="renew_subscription">
    <p>The renewal will extend your subscription for an additional year. It cost about <strong>[[+renew_price_factor]]%</strong> of the current product price.</p>
    <table class="hgrid info">
        <tr><th>Product</th><th>Current Expiry</th><th>New Expiry</th><th>Price</th></tr>
        <tr>
            <td class="product">[[+name]]</td>
            <td class="expiry">[[+subscription_expiry]]</td>
            <td class="new_expiry">[[+new_subscription_expiry]]</td>
            <td class="price">$[[+renew_price]]</td>
        </tr>
    </table>
    <form action="[[~[[*id]]]]" method="post">
        <p>Are you sure you want to continue?</p>
        <input type="hidden" name="action" value="renew" />
        <input type="hidden" name="license" value="[[+id]]" />
        <input type="submit" value="Renew" class="btn_a" />
        <a class="btn_a" href="[[+details_url]]">Cancel</a>
    </form>
</div>
