///////////////////////////////////////////
// いいね！用のJavaScript
///////////////////////////////////////////


$(function() {
  // いいね！がクリックされたとき
  $('.js-like').click(function() {
    const this_obj = $(this); //$(this)の中にクリックされた情報が入る
    const like_id = $(this).data('like-id');
    const like_count_obj = $(this).parent().find('.js-like-count');
    let like_count = Number(like_count_obj.html()); 

    if (like_id) { 
      /**
       * 自分がいいね！できるのは1回だから、、
       * 既にいいね！があれば、取り消し => いいね！カウント減らす
       */
      like_count--;
      like_count_obj.html(like_count);
      this_obj.data('like-id', null);

      // いいね！ボタンの色をグレーに変更
      $(this).find('img').attr('src', '../Views/img/icon-heart.svg');
    } else {
      /**
       * いいね！付与
       * いいね！カウント増やす
       */
      like_count++;
      like_count_obj.html(like_count);
      this_obj.data('like-id', true);

      // いいね！ボタンの色を青に変更
      $(this).find('img').attr('src', '../Views/img/icon-heart-twitterblue.svg');
    }
  })
})