
modISV.grid.Files = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        id: 'modisv-grid-files',
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/file/getlist',
            release: modISV.request.id
        },
        fields: ['id', 'name', 'subtitle', 'path', 'icon', 'guid', 'size', 'download_count', 'checksum', 'createdon', 'updatedon', 'requirements', 'description', 'members_only', 'customers_only', 'menu'],
        autoHeight: true,
        paging: true,
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
            renderer: function(val, x, store) {return val + ' ' + store.data.subtitle;},
            width: 150
        },
        {
            header: 'Icon',
            dataIndex: 'icon',
            width: 100
        },
        {
            header: 'Path',
            dataIndex: 'path',
            renderer: renderFilePath,
            width: 200
        },
        {
            header: 'GUID',
            dataIndex: 'guid',
            width: 200
        },
        {
            header: 'Size',
            dataIndex: 'size',
            renderer: renderFileSize,
            width: 50
        },
        {
            header: 'Checksum',
            dataIndex: 'checksum',
            width: 200
        },
        {
            header: 'Download Count',
            dataIndex: 'download_count',
            width: 100
        },
        {
            header: 'Created On',
            dataIndex: 'createdon',
            width: 100
        },
        {
            header: 'Updated On',
            dataIndex: 'updatedon',
            width: 100
        },
        {
            header: 'Members Only',
            dataIndex: 'members_only',
            renderer: renderBoolean,
            width: 100
        },
        {
            header: 'Customers Only',
            dataIndex: 'customers_only',
            renderer: renderBoolean,
            width: 100
        }],
        tbar: [{
            text: 'Create File',
            handler: this.createFile,
            scope: this
        }]
    });
    modISV.grid.Files.superclass.constructor.call(this, config);
};

Ext.extend(modISV.grid.Files, MODx.grid.Grid, {
    windows: {},
    createFile: function (btn, e) {
        if (!this.windows.createFile) {
            this.windows.createFile = MODx.load({
                xtype: 'modisv-window-file',
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
        this.windows.createFile.fp.getForm().reset();
        this.windows.createFile.show(e.target);
    },
    updateFile: function (btn, e) {
        if (this.menu.record && this.menu.record.id)
            location.href = '?a=' + modISV.request.a + '&sa=file&id=' + this.menu.record.id;
    },
    removeFile: function (btn, e) {
        if (!this.menu.record) return false;

        MODx.msg.confirm({
            title: 'Remove File',
            text: 'Are you sure you want to remove this file?',
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/file/remove',
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
    },
    updateInfo: function (btn, e) {
        if (!this.menu.record) return false;
        MODx.Ajax.request({
            url: modISV.config.connector_url,
            params: {
                action: 'mgr/file/updateinfo',
                id: this.menu.record.id
            },
            listeners: {
                'success': {
                    fn: function(r) {
                        this.refresh();
                    },
                    scope:this
                }
            }
        });
    }
});
Ext.reg('modisv-grid-files', modISV.grid.Files);