
/**
 * A panel used to update an entity.
 */
modISV.UpdatePanel = function (config) {
    config = config || {};

    if(!config.entity)
        return;

    // calculate default config values
    Ext.applyIf(config, {
        // the url to load the entity
        loadUrl: modISV.config.connector_url,
        // the query params to load the entity
        loadParams: {
            action: 'mgr/' + config.entity + '/get',
            id: modISV.request.id
        },
        // the url to save the entity
        updateUrl: modISV.config.connector_url,
        // the query params to save the entity
        updateParams: {
            action: 'mgr/' + config.entity + '/update',
            id: modISV.request.id
        },
        // the form panel to edit the entity
        formPanel: 'modisv-form-' + config.entity,
        // the header text
        headerText: config.entity.charAt(0).toUpperCase() + config.entity.slice(1),
        // the field name of the entity to update the header text
        headerField: 'name' 
    });

    Ext.applyIf(config, {
        border: false,
        baseCls: 'modx-formpanel',
        items: [{
            html: '<h2>' + config.headerText + '</h2>',
            border: false,
            id: 'modisv-updatepanel-header',
            cls: 'modx-page-header'
        },
        {
            xtype: 'modisv-tabs',
            items: [{
                title: 'Details',
                items: [{
                    xtype: config.formPanel,
                    id: config.formPanel,
                    url: config.updateUrl,
                    baseParams: config.updateParams,
                    update: true,
                    labelWidth: 130,
                    buttonAlign: 'left',
                    buttons: [{
                        text: 'Save',
                        handler: this.submit,
                        scope: this
                    },
                    {
                        text: 'Cancel',
                        handler: function () {
                            history.back(1);
                        }
                    }],
                    listeners: {
                        'success': {
                            fn: this.submitSuccess,
                            scope: this
                        }
                    }
                }]
            }].concat(config.extraTabs || [])
        }]
    });
    modISV.UpdatePanel.superclass.constructor.call(this, config);

    // load the entity via ajax request
    this.loadEntity();
};
Ext.extend(modISV.UpdatePanel, MODx.Panel, {
    getFormPanel: function() {
        return Ext.getCmp(this.config.formPanel);
    },
    loadEntity: function () {
        var mask = new Ext.LoadMask(this.getEl(), { msg: "Loading" });
        mask.show();
        MODx.Ajax.request({
            url: this.config.loadUrl,
            params: this.config.loadParams,
            listeners: {
                'success': {
                    fn: function (r) {
                        this.getFormPanel().getForm().setValues(r.object);
                        mask.hide();
                        this.updateHeaderText();
                    },
                    scope: this
                },
                'failure': {
                    fn: function (r) {
                        MODx.form.Handler.errorExt(r, this);
                        mask.hide();
                    },
                    scope: this
                }
            }
        });
    },
    submit: function() {
        this.getFormPanel().submit();
    },
    submitSuccess: function (o) {
        MODx.msg.status({
            title: 'Success',
            message: 'Successfully saved!',
            dontHide: o.result.message != '' ? true : false
        });
        this.updateHeaderText();
    },
    updateHeaderText: function() {
        var text = this.getFormPanel().getForm().findField(this.config.headerField).getValue();
        Ext.getCmp('modisv-updatepanel-header').getEl().update('<h2>' + this.config.headerText + ' - ' + text + '</h2>');
    }
});
Ext.reg('modisv-updatepanel', modISV.UpdatePanel);