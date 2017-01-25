var fetchAgree = function (id, localHostname) {

    var baseUrl = 'https://www.zhihu.com';
    var postUrl = 'https://' + localHostname + '/submitData.php';

    var current = '/answer/' + id + '/voters_profile';

    var data = [];

    var getGender = function (str) {
        switch (str) {
            case '关注':
                return 'none';
            case '关注他':
                return 'male';
            case '关注她':
                return 'female';
            default:
                return 'unknown';
        }
    };

    var run = function () {
        console.log(current);
        $.get(baseUrl + current, function (ret) {
            if (0 !== ret.code) {
                return;
            }
            ret.payload.map(function (str) {
                var tmp = $(str);
                data.push({
                    gender: getGender(tmp.find('.zg-btn-follow').text()),
                    title: tmp.find('.zm-item-link-avatar').attr('title'),
                    img: tmp.find('.zm-item-img-avatar').attr('src'),
                    link: tmp.find('.author-link').attr('href'),
                    bio: tmp.find('.bio').text(),
                    num_agree: parseInt(tmp.find('.status li').eq(0).text(), 10),
                    num_thx: parseInt(tmp.find('.status li').eq(1).text(), 10),
                    num_question: parseInt(tmp.find('.status li').eq(2).text(), 10),
                    num_answer: parseInt(tmp.find('.status li').eq(3).text(), 10),
                });
            });
            if ('' !== ret.paging.next) {
                current = ret.paging.next;
                run();
            } else {
                $.post(postUrl, {
                    data: JSON.stringify(data),
                    id: id
                }, function (ret) {
                    if (0 === ret.err) {
                        console.log(ret.file);
                    }
                }, 'json');
            }
        }, 'json');
    }

    run();
};