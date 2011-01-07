<div class="upgrade_license">
    [[!If? &subject=`[[+subscription_expired]]` &operator=`=` &operand=`1` &then=`
    <p>Since your subscription has expired, you need to purchase an upgrade license, which will cost about <strong>[[+upgrade_price_factor]]%</strong> of the current product price.</p>
    ` &else=`
    <p>The upgrade will convert your license below to the new version. And since the license is within subscription period, the upgrade is free of charge.</p>
    `]]
    <table class="hgrid info">
        <tr><th>Product</th><th>Upgrade To</th><th>Price</th></tr>
        <tr>
            <td class="product">[[+name]]</td>
            <td class="upgradeto">[[+upgrade_to]]</td>
            <td class="cost">$[[+upgrade_price]]</td>
        </tr>
    </table>

    <form action="[[~[[*id]]]]" method="post">
        <p>Are you sure you want to continue?</p>
        <input type="hidden" name="action" value="upgrade" />
        <input type="hidden" name="license" value="[[+id]]" />
        <input type="submit" value="Upgrade" class="btn_a" />
        <a class="btn_a" href="[[+details_url]]">Cancel</a>
    </form>
</div>