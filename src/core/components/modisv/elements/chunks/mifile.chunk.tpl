<tr class="[[+class]]">
    <td class="title">
        <img alt="" src="assets/site/images/filetypes/[[+icon]].png"/>
        [[+name]]
        [[!If? &subject=`[[+subtitle]]` &operator=`isnotempty` &then=`
        <em>[[+subtitle]]</em>
        `]]
    </td>
    <td class="size">[[+size:miFileSize]]</td>
    <td class="download">
        <a href="[[+download_url]]" class="downloadbutton">Download</a>
        <div class="tooltip" style="">
            <dl>
                <dt>File:</dt>
                <dd>[[+filename]]</dd>
            </dl>
            <dl>
                <dt>Created:</dt>
                <dd>[[+createdon:strtotime:date=`%Y-%m-%d`]]</dd>
            </dl>
            <dl>
                <dt>Updated:</dt>
                <dd>[[+updatedon:strtotime:date=`%Y-%m-%d`]]</dd>
            </dl>
            <dl>
                <dt>Size:</dt>
                <dd>[[+size:miFileSize]]</dd>
            </dl>
            [[!If? &subject=`[[+checksum]]` &operator=`isnotempty` &then=`
            <dl>
                <dt>MD5 Checksum:</dt>
                <dd>[[+checksum]]</dd>
            </dl>
            `]]
            [[!If? &subject=`[[+requirements]]` &operator=`isnotempty` &then=`
            <dl>
                <dt>Requirements:</dt>
                <dd>[[+requirements:nl2br]]</dd>
            </dl>
            `]]
            [[!If? &subject=`[[+description]]` &operator=`isnotempty` &then=`
            <dl>
                <dt>Description:</dt>
                <dd>[[+description]]</dd>
            </dl>
            `]]
            [[!If? &subject=`[[+members_only]]` &operator=`=` &operand=`1` &then=`
            <dl class="access">
                <dt>Access:</dt>
                <dd>Members Only</dd>
            </dl>
            `]]
        </div>
    </td>
</tr>