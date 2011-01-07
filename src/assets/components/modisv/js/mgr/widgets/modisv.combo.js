
modISV.combo.LicensingMethod = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miRelease',
            field: 'licensing_method'
        }
    });
    modISV.combo.LicensingMethod.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.LicensingMethod, MODx.combo.ComboBox);
Ext.reg('modisv-combo-licensing-method', modISV.combo.LicensingMethod);

modISV.combo.LicensingMode = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miRelease',
            field: 'licensing_mode'
        }
    });
    modISV.combo.LicensingMode.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.LicensingMode, MODx.combo.ComboBox);
Ext.reg('modisv-combo-licensing-mode', modISV.combo.LicensingMode);

modISV.combo.FileIcon = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        store: new Ext.data.SimpleStore({
            fields: ['v'],
            data: [['none'],['zip'],['installer'],['exe'],['txt'],['pdf'],['chm'],['windows'],['linux'],['mac'],['dotnet'],['java']]
        }),
        displayField: 'v',
        valueField: 'v',
        mode: 'local',
        triggerAction: 'all',
        editable: false,
        value: 'none'
    });
    modISV.combo.FileIcon.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.FileIcon, MODx.combo.ComboBox);
Ext.reg('modisv-combo-file-icon', modISV.combo.FileIcon);

modISV.combo.OrderStatus = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'status',
        hiddenName: 'status',
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miOrder',
            field: 'status'
        }
    });
    modISV.combo.OrderStatus.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.OrderStatus, MODx.combo.ComboBox);
Ext.reg('modisv-combo-order-status', modISV.combo.OrderStatus);

modISV.combo.PaymentProcessor = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miOrder',
            field: 'payment_processor'
        }
    });
    modISV.combo.PaymentProcessor.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.PaymentProcessor, MODx.combo.ComboBox);
Ext.reg('modisv-combo-payment-processor', modISV.combo.PaymentProcessor);

modISV.combo.OrderItemAction = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miOrderItem',
            field: 'action'
        }
    });
    modISV.combo.OrderItemAction.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.OrderItemAction, MODx.combo.ComboBox);
Ext.reg('modisv-combo-orderitem-action', modISV.combo.OrderItemAction);

modISV.combo.PaymentProcessor = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miOrder',
            field: 'payment_processor'
        }
    });
    modISV.combo.PaymentProcessor.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.PaymentProcessor, MODx.combo.ComboBox);
Ext.reg('modisv-combo-payment-processor', modISV.combo.PaymentProcessor);

modISV.combo.Edition = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'fullName',
        valueField: 'id',
        fields: ['id','fullName'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/edition/getall'
        }
    });
    modISV.combo.Edition.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.Edition, MODx.combo.ComboBox);
Ext.reg('modisv-combo-edition', modISV.combo.Edition);

modISV.combo.ClientCategory = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        displayField: 'text',
        valueField: 'value',
        fields: ['value','text'],
        pageSize: 20,
        url: modISV.config.connector_url,
        baseParams: {
            action: 'mgr/getenum',
            'class': 'miClient',
            field: 'category'
        }
    });
    modISV.combo.ClientCategory.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.ClientCategory, MODx.combo.ComboBox);
Ext.reg('modisv-combo-client-category', modISV.combo.ClientCategory);

modISV.combo.User = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'user',
        hiddenName: 'user',
        editable: true,
        typeAhead: true
    });
    modISV.combo.User.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.User, MODx.combo.User);
Ext.reg('modisv-combo-user', modISV.combo.User);

modISV.combo.Snippet = function(config) {
    config = config || {};
    Ext.applyIf(config,{
        name: 'snippet',
        hiddenName: 'snippet',
        displayField: 'name',
        valueField: 'name',
        fields: ['name'],
        forceSelection: true,
        editable: false,
        allowBlank: false,
        pageSize: 20,
        url: MODx.config.connectors_url + 'element/snippet.php'
    });
    modISV.combo.Snippet.superclass.constructor.call(this,config);
};
Ext.extend(modISV.combo.Snippet, MODx.combo.ComboBox);
Ext.reg('modisv-combo-snippet', modISV.combo.Snippet);