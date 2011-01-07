
/**
 * A window used to create an entity.
 */
modISV.CreateWindow = function (config) {
    config = config || {};

    if(!config.entity)
        return;

    // calculate default config values
    Ext.applyIf(config, {
        // the url to create the entity
        url: modISV.config.connector_url,
        // the form panel
        formPanel: 'modisv-form-' + config.entity,
        // the window title
        title: 'Create ' + config.entity.charAt(0).toUpperCase() + config.entity.slice(1),
        // window dimensions
        height: 150,
        width: 530,
        // to suppress enter-submit
        keys: {} 
    });

    // the query params to create the entity
    if(!config.baseParams) {
        config.baseParams = {
            action: 'mgr/' + config.entity + '/create'
        };
        if(config.parentEntity) {
            config.baseParams[config.parentEntity] = modISV.request.id;
        }
    }

    modISV.CreateWindow.superclass.constructor.call(this, config);
};
Ext.extend(modISV.CreateWindow, MODx.Window, {
    createForm: function (config) {
        config = config || {};

        // we don't support setting items, since all items are defined in the form panel specified by 'config.formPanel'
        if(config.items)
            delete config.items;

        Ext.applyIf(config, {
            xtype: this.config.formPanel,
            update: false,
            labelAlign: 'right',
            labelWidth: 140,
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
Ext.reg('modisv-createwindow', modISV.CreateWindow);