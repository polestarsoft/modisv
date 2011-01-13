
modISV.grid.Milestones = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-milestones',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/roadmap/get'
        },
        fields: ['product', 'product_name', 'name', 'total', 'opened', 'menu'],
        autoHeight: true,
        paging: true,
        pageSize: 30,
        columns: [{
            header: 'Product',
            dataIndex: 'product_name',
            sortable: true,
            width: 100
        },
        {
            header: 'Name',
            dataIndex: 'name',
            sortable: true,
            width: 100
        },
        {
            header: 'Process',
            dataIndex: 'process',
            sortable: true,
            renderer: this.renderProcess,
            width: 100
        }],
        tbar: [{
            xtype: 'modisv-combo-product',
            emptyText: 'Search',
            listeners:{
                'select': this.search,
                scope: this
            }
        }]
    });
    modISV.grid.Milestones.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Milestones, MODx.grid.Grid, {
    windows: {},
    viewMilestone: function (btn, e) {
        if (this.menu.record)
            location.href = '?a=' + modISV.request.a + '&sa=milestone&product=' + this.menu.record.product + '&name=' + this.menu.record.name;
    },
    search: function(combo, record, index) {
        this.getStore().baseParams = {
            action: 'mgr/roadmap/get',
            product: record.id
        };
        this.getBottomToolbar().changePage(1);
        this.refresh();
    },
    renderProcess: function(val, meta, store) {
        var total = store.data.total;
        var opened = store.data.opened;
        var process = Math.round((total - opened) * 100 / total);
        var tpl = Ext.DomHelper.createTemplate('\
            <div style="height: 14px; position:relative; background:#ddd; -moz-border-radius:3px; -webkit-border-radius:3px;">\
                <div style="position:absolute; width:100%; background:#4a4; height:14px; width:{p1}%; -moz-border-radius:3px 0 0 3px; -webkit-border-radius:3px 0 0 3px;"></div>\
                <div style="position:absolute; z-index:1; width:100%; text-align:center; color:#333; font-weight:bold;">{p1}% &nbsp;&nbsp;&nbsp;[{c1} / {total}]</div>\
            </div>');
        return tpl.apply({
            'p1': process,
            'p2': 100 - process,
            'c1': total - opened,
            'c2': opened,
            'total': total
        });
    }
});
Ext.reg('modisv-grid-milestones', modISV.grid.Milestones);