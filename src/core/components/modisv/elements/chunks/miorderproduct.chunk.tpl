<div class="order_product">
    <form action="[[~[[*id]]]]" method="post">
        <fieldset>
            <dl class="edition">
                <dt><label>Edition</label></dt>
                <dd>
                    [[+editions_html]]
                    <span class="error">[[+error.edition]]</span>
                </dd>
            </dl>
            <dl class="quantity">
                <dt><label for="quantity">Number of Licenses</label></dt>
                <dd>
                    <select id="quantity" name="quantity">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                        <option value="40">40</option>
                        <option value="50">50</option>
                        <option value="60">60</option>
                        <option value="70">70</option>
                        <option value="80">80</option>
                        <option value="90">90</option>
                        <option value="100">100</option>
                    </select>
                    <span class="error">[[+error.quantity]]</span>
                </dd>
            </dl>
            <dl class="subscription">
                <dt><label for="subscription">Subscription Option</label></dt>
                <dd>
                    [[+subscriptions_html]]
                    <span class="error">[[+error.subscription]]</span>
                </dd>
            </dl>
            <dl class="purchase">
                <dt>&nbsp;</dt>
                <dd>
                    <input type="submit" value="Purchase Now" class="btn_a" />
                </dd>
            </dl>
        </fieldset>
    </form>
</div>
