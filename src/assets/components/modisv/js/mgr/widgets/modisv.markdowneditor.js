modISV.MaskDownEditor = function(config){
    modISV.MaskDownEditor.superclass.constructor.call(this, config);
};
Ext.extend(modISV.MaskDownEditor, Ext.form.TextArea, {
});
Ext.reg('modisv-maskdowneditor', modISV.MaskDownEditor);
