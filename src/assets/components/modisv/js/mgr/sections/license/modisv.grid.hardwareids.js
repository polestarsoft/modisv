
modISV.grid.HardwareIDs = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-hardwareids',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/hardwareid/getlist',
            license: modISV.request.id
        },
        fields: ['id', 'name', 'createdon', 'ip', 'menu'],
        autoHeight: true,
        paging: true,
        columns: [{
            header: 'ID',
            dataIndex: 'id',
            width: 100
        },
        {
            header: 'Name',
            dataIndex: 'name',
            width: 200
        },
        {
            header: 'Created On',
            dataIndex: 'createdon',
            renderer: renderDate,
            width: 100
        },
        {
            header: 'IP Address',
            dataIndex: 'ip',
            width: 100
        }],
        tbar: [{
            text: 'Create Hardware ID',
            handler: this.createHardwareID,
            scope: this
        }]
    });
    modISV.grid.HardwareIDs.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.HardwareIDs, MODx.grid.Grid, {
    windows: {},
    createHardwareID: function (btn, e) {
        if (!this.windows.createHardwareID) {
            this.windows.createHardwareID = MODx.load({
                xtype: 'modisv-window-hardwareid',
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
        this.windows.createHardwareID.fp.getForm().reset();
        this.windows.createHardwareID.show(e.target);
    },
    updateHardwareID: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=hardwareid&id=' + this.menu.record.id;
    },
    removeHardwareID: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Hareware ID',
            text: 'Are you sure you want to remove this hardware ID?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/hardwareid/remove',
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
Ext.reg('modisv-grid-hardwareids', modISV.grid.HardwareIDs);