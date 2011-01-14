// please include the scripts and css
// <script type="text/javascript" src="wmd.js"></script>
// <script type="text/javascript" src="showdown.js"></script>
// <link href="wmd.css" type="text/css" rel="stylesheet">

PS = {};
PS.WmdEditor = function(config){
    PS.WmdEditor.superclass.constructor.call(this, config);
};
Ext.extend(PS.WmdEditor, Ext.form.TextArea, {
    onRender: function(ct, position) {
        PS.WmdEditor.superclass.onRender.call(this, ct, position);
        this.wrap = this.el.wrap({
            cls: 'x-form-field-wrap'
        });
        this.buttonBar = this.wrap.createChild({
            tag: 'div',
            id: this.getId() + '-button-bar',
            cls: 'wmd-button-bar'
        }, this.el.dom);
        this.preview = this.wrap.createChild({
            tag: 'div',
            id: this.getId() + '-preview',
            cls: 'wmd-preview'
        });
        this.addClass('wmd-input');
        eval('setup_wmd({ input:"{0}", button_bar:"{0}-button-bar", preview:"{0}-preview" });'.format(this.getId()));
    },
    onResize: function(w, h) {
        PS.WmdEditor.superclass.onResize.call(this, w, h);
        this.el.setWidth('100%');
        this.buttonBar.setWidth('100%');
        this.preview.setWidth('100%');
        this.wrap.setWidth(w);
    }
});
Ext.reg('modisv-maskdowneditor', PS.WmdEditor);
