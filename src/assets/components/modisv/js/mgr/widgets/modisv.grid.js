modISV.Grid = function (config) {
    config = config || {};
    Ext.applyIf(config, {
        autoHeight: true,
        paging: true
    });
    modISV.Grid.superclass.constructor.call(this, config);
};
Ext.extend(modISV.Grid, MODx.grid.Grid, {
});
Ext.reg('modisv-grid', modISV.Grid);