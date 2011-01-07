
/**
 * Allows validation messages along with field tooltips.
 */
Ext.onReady(function(){
    Ext.form.Field.prototype.msgTarget = 'side';
    Ext.QuickTips.init();
    var getAutoCreate = Ext.form.Field.prototype.getAutoCreate;
    Ext.override(Ext.form.Field, {
        getAutoCreate: function() {
            var cfg = getAutoCreate.call(this);
            if(this.description != null) {
                cfg['ext:qtip'] = this.description;
                cfg['ext:qwidth'] = 100;
            }
            return cfg;
        }
    });
});