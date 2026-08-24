(function(){
  if(window.__tedtecGlobalFooter)return;window.__tedtecGlobalFooter=true;
  var footer=document.querySelector('.tt-final-footer');
  if(!footer)return;
  var shareButton=footer.querySelector('[data-tt-share]');
  if(shareButton)shareButton.addEventListener('click',async function(){
    var label=shareButton.querySelector('[data-tt-share-label]');
    var original='Compartilhar ↗';
    try{
      if(navigator.share){await navigator.share({title:document.title,url:window.location.href});label.textContent='Compartilhado'}
      else{await navigator.clipboard.writeText(window.location.href);label.textContent='Link copiado'}
    }catch(error){
      if(error&&error.name==='AbortError')return;
      try{await navigator.clipboard.writeText(window.location.href);label.textContent='Link copiado'}catch(copyError){label.textContent='Não foi possível copiar'}
    }
    window.setTimeout(function(){label.textContent=original},1800);
  });
  var reveal=footer.querySelector('[data-tt-footer-reveal]');
  var reduce=window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if(!reveal||reduce||!('IntersectionObserver' in window)){if(reveal)reveal.classList.add('is-visible');return}
  footer.classList.add('is-reveal-ready');
  var observer=new IntersectionObserver(function(entries){entries.forEach(function(entry){if(entry.isIntersecting){entry.target.classList.add('is-visible');observer.disconnect()}})},{threshold:.14,rootMargin:'0px 0px -24px 0px'});
  observer.observe(reveal);
})();
