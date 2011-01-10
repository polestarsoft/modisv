
modISV.grid.Releases = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/release/getlist',
            product: modISV.request.id
        },
        fields: ['id', 'name', 'version', 'beta', 'createdon', 'changes', 'licensing_mode', 'licensing_method', 'code_generator', 'upgrade_rules',  'initial_subscription', 'menu'],
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
            header: 'Version',
            dataIndex: 'version',
            sortable: true,
            width: 100
        },
        {
            header: 'Beta',
            dataIndex: 'beta',
            renderer: renderBoolean,
            width: 50
        },
        {
            header: 'Created On',
            dataIndex: 'createdon',
            sortable: true,
            width: 100
        },
        {
            header: 'Licensing Mode',
            dataIndex: 'licensing_mode',
            width: 100
        },
        {
            header: 'Licensing Method',
            dataIndex: 'licensing_method',
            width: 100
        },
        {
            header: 'Code Generator',
            dataIndex: 'code_generator',
            width: 100
        },
        {
            header: 'Initial Subscription',
            dataIndex: 'initial_subscription',
            renderer: function(val) {
                return val + ' months';
            },
            width: 100
        }],
        tbar: [{
            text: 'Create Release',
            handler: this.createRelease,
            scope: this
        }]
    });
    modISV.grid.Releases.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Releases, modISV.Grid, {
    windows: {},
    createRelease: function (btn, e) {
        MODx.load({
            xtype: 'modisv-window-release',
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
    updateRelease: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=release&id=' + this.menu.record.id;
    },
    removeRelease: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove Release',
            text: 'Are you sure you want to remove this release? All its editions/updates/files will also be removed.',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/release/remove',
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
Ext.reg('modisv-grid-releases', modISV.grid.Releases);