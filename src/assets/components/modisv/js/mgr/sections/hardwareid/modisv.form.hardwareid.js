
modISV.form.HardwareID = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        items: [{
            title: 'General Information',
            xtype: 'fieldset',
            items: [{
                xtype: 'textfield',
                fieldLabel: 'Name',
                name: 'name',
                width: 300
            },
            {
                xtype: 'datefield',
                altFormats: 'Y-m-d H:i:s',
                fieldLabel: 'Created On',
                name: 'createdon',
                width: 300
            },
            {
                xtype: 'textfield',
                fieldLabel: 'IP Address',
                name: 'ip',
                width: 300
            },
            {
                xtype: 'hidden',
                name: 'id'
            }]
        }]
    });
    modISV.form.HardwareID.superclass.constructor.call(this, config);
};
Ext.extend(modISV.form.HardwareID, MODx.FormPanel);
Ext.reg('modisv-form-hardwareid', modISV.form.HardwareID);