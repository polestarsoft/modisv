modISV.MaskDownEditor = function(config){
    modISV.MaskDownEditor.superclass.constructor.call(this, config);
};
Ext.extend(modISV.MaskDownEditor, PS.WmdEditor);
Ext.reg('modisv-maskdowneditor', modISV.MaskDownEditor);
