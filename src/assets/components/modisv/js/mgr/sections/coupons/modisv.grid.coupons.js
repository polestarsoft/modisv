
modISV.grid.Coupons = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-coupons',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/coupon/getlist'
        },
        fields: ['id', 'name', 'code', 'discount', 'discount_in_percent', 'enabled', 'quantity', 'used', 'editions', 'actions', 'valid_from', 'valid_to', 'menu'],
        autoHeight: true,
        paging: true,
        pageSize: 30,
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 50
        },
        {
            header: 'Name',
            dataIndex: 'name',
            sortable: true,
            width: 100
        },
        {
            header: 'Code',
            dataIndex: 'code',
            sortable: true,
            width: 100
        },
        {
            header: 'Discount',
            dataIndex: 'discount',
            sortable: true,
            renderer: renderCouponDiscount,
            width: 60
        },
        {
            header: 'Enabled',
            dataIndex: 'enabled',
            sortable: true,
            renderer: renderBoolean,
            width: 60
        },
        {
            header: 'Quantity',
            sortable: true,
            dataIndex: 'quantity',
            width: 60
        },
        {
            header: 'Used',
            sortable: true,
            dataIndex: 'used',
            width: 60
        },
        {
            header: 'Editions',
            dataIndex: 'editions',
            sortable: true,
            renderer: renderEditions,
            width: 100
        },
        {
            header: 'Actions',
            sortable: true,
            dataIndex: 'actions',
            width: 100
        },
        {
            header: 'Valid From',
            dataIndex: 'valid_from',
            sortable: true,
            renderer: renderDate,
            width: 100
        },
        {
            header: 'Valid To',
            dataIndex: 'valid_to',
            sortable: true,
            renderer: renderDate,
            width: 100
        }],
        tbar: [{
            text: 'Create Coupon',
            handler: this.createCoupon,
            scope: this
        }]
    });
    modISV.grid.Coupons.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Coupons, MODx.grid.Grid, {
    windows: {},
    createCoupon: function (btn, e) {
        if (!this.windows.createCoupon) {
            this.windows.createCoupon = MODx.load({
                xtype: 'modisv-window-coupon',
                listeners: {
                    'success': {
                        fn: function () {
                            this.refresh();
                        },
                        scope: this
                    }
                }
            });
        }
        this.windows.createCoupon.fp.getForm().reset();
        this.windows.createCoupon.show(e.target);
    },
    updateCoupon: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=coupon&id=' + this.menu.record.id;
    },
    removeCoupon: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Coupon',
            text: 'Are you sure you want to remove this coupon?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/coupon/remove',
                id: this.menu.record.id
            },
            listeners: {
                'success': {
                    fn: function (r) {
                        this.refresh();
                    },
                    scope: this
                }
            }
        });
        return true;
    }
});
Ext.reg('modisv-grid-coupons', modISV.grid.Coupons);