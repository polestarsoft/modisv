
modISV.LicenseTypeField = function(config){
    config = config || {};
    this.ident = config.ident || Ext.id();
    Ext.apply(config, {
        items: [{
            xtype: 'combo',
            id: this.ident + '-types',
            store: new Ext.data.SimpleStore({
                fields: ['v'],
                data:
                [['Single User License'],
                ['Single Developer License'],
                ['Single Server License'],
                ['Enterprise License'],
                ['Site License'],
                ['OEM License'],
                ['Custom License'],
                ['Source Code License']]
            }),
            displayField: 'v',
            mode: 'local',
            triggerAction: 'all',
            editable: false,
            width: config.width - 130,
            listeners: {
                'change': {
                    fn: this.changeValue,
                    scope: this
                }
            }
        },
        {
            xtype: 'label',
            text: 'for',
            width: '15'
        },
        {
            xtype: 'combo',
            id: this.ident + '-options',
            submitValue: false,
            store: new Ext.data.SimpleStore({
                fields: ['v'],
                data:
                [['none'],
                ['Academic'],
                ['Government'],
                ['NPO'],
                ['Reseller']]
            }),
            displayField: 'v',
            mode: 'local',
            triggerAction: 'all',
            editable: false,
            width: 105,
            listeners: {
                'change': {
                    fn: this.changeValue,
                    scope: this
                }
            }
        },
        {
            xtype: 'hidden',
            id: this.ident + '-hidden',
            name: config.name
        }]
    });

    this.setValue(config.value || 'Single User License');
    
    modISV.LicenseTypeField.superclass.constructor.call(this, config);

    this.on('afterrender', this.afterRender, this);
};

Ext.extend(modISV.LicenseTypeField, Ext.form.CompositeField, {
    changeValue: function() {
        var types = Ext.getCmp(this.ident + '-types');
        var options = Ext.getCmp(this.ident + '-options');
        var hidden = Ext.getCmp(this.ident + '-hidden');

        var value = types.getValue();
        if(options.getValue() != 'none')
            value += ' for ' + options.getValue();
        hidden.setValue(value);
    },
    getValue: function() {
        if(!this.rendered) {
            return this.value;
        }
        var hidden = Ext.getCmp(this.ident + '-hidden');
        return hidden.getValue();
    },
    setValue: function(v) {
        this.value = v;
        if(this.rendered) {
            var types = Ext.getCmp(this.ident + '-types');
            var options = Ext.getCmp(this.ident + '-options');
            var hidden = Ext.getCmp(this.ident + '-hidden');
            var parts = (v || '').split(' for ');
            types.setValue(parts[0]);
            options.setValue(parts.length == 2 ? parts[1] : 'none');
            hidden.setValue(v);
        }
        return this;
    },
    afterRender: function() {
        this.setValue(this.value);
    }

});
Ext.reg('modisv-licensetypefield', modISV.LicenseTypeField);