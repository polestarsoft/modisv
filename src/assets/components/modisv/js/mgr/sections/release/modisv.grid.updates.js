
modISV.grid.Updates = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-updates',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/update/getlist',
            release: modISV.request.id
        },
        fields: ['id', 'version', 'changes', 'createdon', 'menu'],
        autoHeight: true,
        paging: true,
        pageSize: 10,
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            sortable: true,
            width: 100
        },
        {
            header: 'Version',
            dataIndex: 'version',
            sortable: true,
            width: 200
        },
        {
            header: 'Created On',
            dataIndex: 'createdon',
            sortable: true,
            width: 200
        },
        {
            header: 'Changes',
            dataIndex: 'changes',
            renderer: renderMultipline,
            width: 300
        }],
        tbar: [{
            text: 'Create Update',
            handler: this.createUpdate,
            scope: this
        }]
    });
    modISV.grid.Updates.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Updates, MODx.grid.Grid, {
    windows: {},
    createUpdate: function (btn, e) {
        MODx.load({
            xtype: 'modisv-window-update',
            listeners: {
                'success': {
                    fn: function () {
                        this.refresh();
                    },
                    scope: this
                }
            }
        }).show(e.target);
    },
    updateUpdate: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=update&id=' + this.menu.record.id;
    },
    removeUpdate: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Update',
            text: 'Are you sure you want to remove this update?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/update/remove',
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
Ext.reg('modisv-grid-updates', modISV.grid.Updates);