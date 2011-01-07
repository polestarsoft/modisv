<h3>License Details</h3>
<div class="license">
    <table class="vgrid">
        <tr>
            <th>Product</th>
            <td>[[+name]]</td>
        </tr>
        <tr>
            <th>License Type</th>
            <td>[[+type]]</td>
        </tr>
        <tr>
            <th>Quantity</th>
            <td>[[+quantity]]</td>
        </tr>
        [[!If? &subject=`[[+licensing_method]]` &operator=`=` &operand=`activation` &then=`
        <tr><th>Used</th><td>[[+used]]</td></tr>
        `]]
        <tr>
            <th>License Name</th>
            <td>[[+license_name]]</td>
        </tr>
        <tr>
            [[!If? &subject=`[[+licensing_method]]` &operator=`=` &operand=`file` &then=`
            <th>License File</th><td><a href="[[+download_url]]">Download</a></td>
            ` &else=`
            <th>License Code</th><td>[[+code]]</td>
            `]]
        </tr>
        <tr>
            <th>Purchased On</th>
            <td>[[+createdon:strtotime:date=`%Y-%m-%d`]]</td>
        </tr>
        <tr>
            <th>Subscription Expiry</th>
            <td>[[+subscription_expiry]]</td>
        </tr>
    </table>
    <p class="buttons">
        [[!If? &subject=`[[+upgrade_available]]` &operator=`=` &operand=`1` &then=`
        <a class="btn_a" href="[[+upgrade_url]]">Upgrade</a>
        `]]
        [[!If? &subject=`[[+renew_available]]` &operator=`=` &operand=`1` &then=`
        <a class="btn_a" href="[[+renew_url]]">Renew</a>
        `]]
    </p>
</div>
<script>$('table.vgrid tr:odd').addClass('alt');</script>
