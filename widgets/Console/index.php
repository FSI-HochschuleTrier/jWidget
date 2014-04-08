<!--
* Console Widget
*
* @author Michael Ochmann (INF | INF - SMS)
-->
<script>

  $('#code').typed({
        strings: ["cat cat", "sudo rm -rf /", "sudo su", "sudo apt-get remove python", ":(){ :|: & };:", "mkfs.ntfs /dev/sda1", "command > /dev/sda",
        "dd if=/dev/random of=/dev/sda", "mv ~ /dev/null", "wget http://example.com/something -O – | sh", "sudo chmod -R 777 /"],
        typeSpeed: 50,
        backDelay: 1000,
        loop: true
      });
</script>
        <div class="wrap">
                <div class="type-wrap">
                        root@fsi:~# <span id="code"></span>
                </div>

        </div>