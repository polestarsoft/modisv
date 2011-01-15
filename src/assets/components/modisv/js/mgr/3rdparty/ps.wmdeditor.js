/**
 * ExtWmdEditor - A markdown editor with preview for ExtJS.
 *
 * Copyright 2010 by Weqiang Wang <wenqiang@polestarsoft.com>
 *
 * ExtWmdEditor is free software; you can redistribute it and/or modify it under the
 * terms of the GNU General Public License as published by the Free Software
 * Foundation; either version 2 of the License, or (at your option) any later
 * version.
 *
 * ExtWmdEditor is distributed in the hope that it will be useful, but WITHOUT ANY
 * WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR
 * A PARTICULAR PURPOSE. See the GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License along with
 * modISV; if not, write to the Free Software Foundation, Inc., 59 Temple
 * Place, Suite 330, Boston, MA 02111-1307 USA
 *
 */

// Rememer to include the scripts and css files in your webpage:
// <script type="text/javascript" src="wmd.js"></script>
// <script type="text/javascript" src="showdown.js"></script>
// <script type="text/javascript" src="prettify.js"></script>
// <link href="wmd.css" type="text/css" rel="stylesheet">
// <link href="prettify.css" type="text/css" rel="stylesheet">

PS = {};
PS.WmdEditor = function(config){
    PS.WmdEditor.superclass.constructor.call(this, config);
};
Ext.extend(PS.WmdEditor, Ext.form.TextArea, {
    onRender: function(ct, position) {
        PS.WmdEditor.superclass.onRender.call(this, ct, position);
        this.wrap = this.el.wrap({
            cls: 'x-form-field-wrap ps-wmd-editor'
        });
        this.buttonBar = this.wrap.createChild({
            tag: 'div',
            id: this.getId() + '-button-bar',
            cls: 'wmd-button-bar'
        }, this.el.dom);
        this.preview = this.wrap.createChild({
            tag: 'div',
            id: this.getId() + '-preview',
            cls: 'wmd-preview wmd'
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
