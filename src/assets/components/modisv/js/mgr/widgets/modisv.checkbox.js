
modISV.Checkbox = function(config){
    modISV.Checkbox.superclass.constructor.call(this, config);
};
Ext.extend(modISV.Checkbox, Ext.form.Checkbox, {
    onRender: function(ct, position) {
        Ext.apply(this, {
            inputValue: '1'
        });
        modISV.Checkbox.superclass.onRender.call(this, ct, position);
        Ext.DomHelper.insertBefore(this.el, {
            tag: 'input',
            type: 'hidden',
            value: '0',
            name: this.getName()
        });
    }
});
Ext.reg('checkbox', modISV.Checkbox);
Ext.reg('modisv-checkbox', modISV.Checkbox);
