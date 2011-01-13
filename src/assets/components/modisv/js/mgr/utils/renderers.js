
function renderBoolean(val) {
    return val ? 'Yes' : 'No';
}

function renderPercentage(val) {
    return val + '%';
}

function renderCurrency(val) {
    return '$' + val.toFixed(2);
}

function renderMultipline(val) {
    return val.replace(/\n/g, '<br />');
}

function renderImageSmall(val) {
    return '<img src="' + MODx.config.base_url + val.replace(/^\//, "") + '" style="width:64px">';
}

function renderFilePath(val) {
    return '<a href="' + MODx.config.base_url + val.replace(/^\//, "") + '">' +  MODx.config.base_url + val.replace(/^\//, "") + '</a>';
}

function renderFileSize(val) {
    return (val / 1024).toFixed(1) + 'KB';
}

function renderDate(val) {
    if(val)
        return '<span qtip="' + val + '">' + val.substring(0, 10) + '</span>';
}

function renderLink(val) {
    if(val)
        return '<a href="' + MODx.config.site_url + val + '">' + val + '</a>';
}

function renderUser(val, meta, store) {
    if(val)
        return '<a href="?a=' + MODx.action['security/user/update'] + '&id=' + val + '">' + (store.data.user_email || val) + '</a>';
}

function renderLicenseType(val) {
    return val.replace('+', ' for ');
}

function renderReleases(val, meta, store) {
    var releases = val.split(',');
    var r = '';
    for (var i = 0; i < releases.length; i++) {
        var e = releases[i].replace(/^\s+|\s+$/g, '');
        if(e != '')
            r += '<a style="margin-right:8px;" href="?a=' + modISV.request.a + '&sa=release' + '&id=' + e + '">#' + e + '</a>';
    }
    return r;
}

function renderEdition(val, meta, store) {
    if(val)
        return '<a href="?a=' + modISV.request.a + '&sa=edition' + '&id=' + val + '">' + (store.data.edition_name || '#' + val) + '</a>';
}

function renderEditions(val) {
    var editions = val.split(',');
    var r = '';
    for (var i = 0; i < editions.length; i++) {
        var e = editions[i].replace(/^\s+|\s+$/g, '');
        if(e != '')
            r += '<a style="margin-right:8px;" href="?a=' + modISV.request.a + '&sa=edition' + '&id=' + e + '">#' + e + '</a> ';
    }
    return r;
}

function renderLicense(val) {
    if(val)
        return '<a href="?a=' + modISV.request.a + '&sa=license' + '&id=' + val + '">#' + val + '</a>';
}

function renderOrder(val) {
    if(val)
        return '<a href="?a=' + modISV.request.a + '&sa=order' + '&id=' + val + '">#' + val + '</a>';
}

function renderCouponDiscount(val, meta, store) {
    return store.data.discount_in_percent ? (val + '%') : ('$' + val.toFixed(2));
}

function renderLicenseCode(val) {
    return val.length < 30 ? val : ('<strong qtip"' + val + '">[...]</strong>');
}

function renderEllipsis(val) {
    return val.length < 10 ? val : ('<strong qtip"' + val + '">[...]</strong>');
}

function renderProduct(val, meta, store) {
    if(val)
        return '<a href="?a=' + modISV.request.a + '&sa=product' + '&id=' + val + '">' + (store.data.product_name || '#' + val) + '</a>';
}

function renderTicketAuthor(val, meta, store) {
    if(val) {
        var qtip = store.data.author_name ? ' qtitle="Name" qtip="' + store.data.author_name + '" ' : '';
        if(store.data.author_id)
            return '<a' + qtip + 'href="?a=' + MODx.action['security/user/update'] + '&id=' + store.data.author_id + '">' + val + '</a>';
        else
            return '<span' + qtip + '>' + val + '</span>';
    }
}

function renderTicketPriority(val) {
    var fg = val > 1 ? '#FFFFFF' : '#000000';
    var bg = val == 5 ? '#FF0000' : val == 4 ? '#FF5B00' : val == 3 ? '#22B14C' : val == 2 ? '#BBBBBB' : '#E0E0E0';
    return '<div style="width:16px; height:16px; background-color:' + bg + '; color:' + fg + '; text-align:center; -moz-border-radius:5px; -webkit-border-radius:5px;">' + val + '</div>';
}

function renderTicketOverdue(val) {
    return val ? '<div style="width:30px; color:#FFF; background-color:#333; text-align:center; -moz-border-radius:5px; -webkit-border-radius:5px;">Due</div>' : 'No';
}

function renderTicketAnswered(val, meta, store) {
    if (store.data.author_id && store.data.author_id == MODx.user.id)
        return '';
    return val ? 'Yes' : '<div style="width:30px; color:#FFF; background-color:#999; text-align:center; -moz-border-radius:5px; -webkit-border-radius:5px;">No</div>';
}

function renderTicketStatus(val) {
    return val == 'open' ? '<div style="width:40px; color:#FFF; background-color:#999; text-align:center; -moz-border-radius:5px; -webkit-border-radius:5px;">Open</div>' : 'Closed';
}

function renderTicketWatchers(val) {
    if(val) {
        var count = val.split(',').length;
        var details = Ext.util.Format.htmlEncode(Ext.util.Format.htmlEncode(val)).replace(/,/g, '<br/>');   // we need encode twice
        return '<span qtitle="Watchers:" qtip="' + details + '">' + count + ' people</span>'
    }
}

function renderTicketSource(val, meta, store) {
    if(val == 'web' || val == 'email')
        return '<span qtitle="IP:" qtip="' + (store.data.ip || '') + '">' + val + '</span>'
    else
        return val;
}

function renderTicketMilestone(val) {
    if(val) {
        return '<a href="?a=' + modISV.request.a + '&sa=milestone' + '&name=' + val + '">' + val + '</a>';
    }
}

function renderTicketLink(val, meta, store) {
    if(val) {
        return '<a href="?a=' + modISV.request.a + '&sa=ticket' + '&id=' + store.data.id + '">' + val + '</a>';
    }
}

function renderTicketMiscInfo(val, meta, store) {
    if(val) {
        var info = 'Created On:  ' + (store.data.createdon || '') + '<br/>';
        info += 'Closed On:   ' + (store.data.closedon || '') + '<br/>';
        info += 'Reopened On: ' + (store.data.reopenedon || '') + '<br/>';
        info += 'Due On:      ' + (store.data.dueon || '') + '<br/>';
        info += 'Last Msg On: ' + (store.data.lastmessageon || '') + '<br/>';
        info += 'Last Rps On: ' + (store.data.lastresponseon || '') + '<br/>';
        info += 'Note:        ' + (store.data.note || '') + '<br/>';
        return '<div qtitle="Misc Info:" qtip="' + info + '">[*]</div>'
    }
}

function renderMessageNum(val, meta, store) {
    if(val) {
        return '<a name="' + store.data.id + '" /><a href="#' + store.data.id + '">#' + val + '</a>';
    }
}
