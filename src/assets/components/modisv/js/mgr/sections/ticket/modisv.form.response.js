
modISV.form.Response = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [
            {
                xtype: 'modisv-maskdowneditor',
                fieldLabel: 'Body',
                name: 'body',
                width: 400,
                grow: true,
                growMax: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.Response.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.Response, MODx.FormPanel);
Ext.reg('modisv-form-response', modISV.form.Response);