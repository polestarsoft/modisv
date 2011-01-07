
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
        return '<span title="' + val + '">' + val.substring(0, 10) + '</span>';
}

function renderLink(val) {
    if(val)
        return '<a href="' + MODx.config.site_url + val + '">' + val + '</a>';
}

function renderUser(val, x, store) {
    if(val)
        return '<a href="?a=' + MODx.action['security/user/update'] + '&id=' + val + '">' + store.data.user_email || val + '</a>';
}

function renderLicenseType(val) {
    return val.replace('+', ' for ');
}

function renderReleases(val, x, store) {
    var releases = val.split(',');
    var r = '';
    for (var i = 0; i < releases.length; i++) {
        var e = releases[i].replace(/^\s+|\s+$/g, '');
        if(e != '')
            r += '<a style="margin-right:8px;" href="?a=' + modISV.request.a + '&sa=release' + '&id=' + e + '">#' + e + '</a>';
    }
    return r;
}

function renderEdition(val, x, store) {
    if(store.data.edition_name && val)
        return '<a href="?a=' + modISV.request.a + '&sa=edition' + '&id=' + val + '">' + store.data.edition_name + '</a>';
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

function renderCouponDiscount(val, x, store) {
    return store.data.discount_in_percent ? (val + '%') : ('$' + val.toFixed(2));
}

function renderLicenseCode(val) {
    return val.length < 30 ? val : ('<strong title="' + val + '">[...]</strong>');
}

function renderEllipsis(val) {
    return val.length < 10 ? val : ('<strong title="' + val + '">[...]</strong>');
}
