
var modISV = function(config) {
    config = config || {};
    modISV.superclass.constructor.call(this, config);
};
Ext.extend(modISV, Ext.Component,{
    page:{}, window:{}, grid:{}, tree:{}, panel:{}, form:{}, combo:{}, config:{}
});
Ext.reg('modisv', modISV);

modISV = new modISV();

