
modISV.RandomField = function(config) {
    config = config || {};
    Ext.applyIf(config, {
        length: 8,
        digits: "ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890"
    });
    modISV.RandomField.superclass.constructor.call(this, config);
};
Ext.extend(modISV.RandomField, Ext.form.TriggerField, {
    onTriggerClick: function(e) {
        if(this.disabled)
            return;
        var text = "";
        var possible = this.initialConfig.digits;
        for(var i=0; i<this.initialConfig.length ; i++)
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        this.setValue(text);
    }
});
Ext.reg('modisv-randomfield', modISV.RandomField);

