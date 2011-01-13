
/**
 * A window used to create an entity.
 */
modISV.Window = function (config) {
    config = config || {};

    if(!config.entity)
        return;

    Ext.applyIf(config, {
        update: false
    });

    // calculate default config values
    Ext.applyIf(config, {
        // the url to create the entity
        url: modISV.config.connector_url,
        // the form panel
        formPanel: 'modisv-form-' + config.entity,
        // the window title
        title: (config.update ? 'Update ' : 'Create ') + config.entity.charAt(0).toUpperCase() + config.entity.slice(1),
        // window dimensions
        height: 150,
        width: 530,
        // label align and width
        labelAlign: 'right',
        labelWidth: 140,
        // to suppress enter-submit
        keys: {} 
    });

    // the query params to create the entity
    if(!config.baseParams) {
        config.baseParams = {
            action: 'mgr/' + config.entity + (config.update ? '/update' : '/create')
        };
        if(config.parentEntity) {
            config.baseParams[config.parentEntity] = modISV.request.id;
        }
    }

    modISV.Window.superclass.constructor.call(this, config);
};
Ext.extend(modISV.Window, MODx.Window, {
    createForm: function (config) {
        config = config || {};

        // we don't support setting items, since all items are defined in the form panel specified by 'config.formPanel'
        if(config.items)
            delete config.items;

        Ext.applyIf(config, {
            xtype: this.config.formPanel,
            update: this.config.update,
            labelAlign: this.config.labelAlign,
            labelWidth: this.config.labelWidth,
            frame: true,
            border: false,
            bodyBorder: false,
            autoHeight: true,
            errorReader: MODx.util.JSONReader,
            fileUpload: this.config.fileUpload || false
        });
        return MODx.load(config);
    }
});
Ext.reg('modisv-window', modISV.Window);