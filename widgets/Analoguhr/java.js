/**
 * Created by Philipp on 31.05.17.
 */


function clock()
{
    let pacmanstate = [];
    pacmanstate[0] = true;
    pacmanstate[1] = false;
    pacmanstate[2] = false;
    pacmanstate[3] = false;

    let ghost1Visible = true;
    let ghost2Visible = true;

    let ghost1DefeatedVisible = false;
    let ghost2DefeatedVisible = false;

    let container = $('#mainContainer');
    let ClockStyleKit = ClockStylekit;

    let date = null;
    let minutes = 0;
    let hour = 0;
    let seconds = 0;
    let milliseconds = 0;

    window.d1 = false;
    window.d2 = false;

    updateTime();
    evaluateGhosts();
    draw();
    clearInterval(window.ctimer);
    window.ctimer = setInterval(myTimer, 50);

    function myTimer()
    {
        updateTime();
        upDatePacmanState();
        evaluateGhosts();
        draw();
    }

    function evaluateGhosts()
    {
        //Evaluate Ghost 2 (minutes)
        if (minutes === seconds)
        {
            if (window.d2 === false)
            {
                window.d2 = true;
                dispatchBlinkingGhost(2);
            }
        }

        //Evaluate Ghost 1 (hour)
        if ((hour * 5) === seconds)
        {
            if (window.d1 === false)
            {
                window.d1 = true;
                dispatchBlinkingGhost(1)
            }
        }
    }


    function dispatchBlinkingGhost(ghost)
    {
        if (Number.isInteger(ghost))
        {
            if (ghost === 1)
            {
                ghost1Visible = false;
                ghost1DefeatedVisible = true;

                window.b1t = true;
                blinck(1);

                setTimeout(function ()
                {
                    window.b1t = false;
                    window.d1 = false;
                    ghost1Visible = true;
                    ghost1DefeatedVisible = false;
                }, 4000);
            }

            if (ghost === 2)
            {
                ghost2Visible = false;
                ghost2DefeatedVisible = true;

                window.b2t = true;
                blinck(2);

                setTimeout(function ()
                {
                    window.b2t = false;
                    window.d2 = false;
                    ghost2Visible = true;
                    ghost2DefeatedVisible = false;
                }, 4000);
            }
        }
    }

    function blinck(ghost)
    {

        if ((ghost === 1) && (window.b1t === true))
        {
            setTimeout(function ()
            {
                ghost1DefeatedVisible ? (ghost1DefeatedVisible = false) : (ghost1DefeatedVisible = true);
                blinck(1);
            }, 500);
        }

        if ((ghost === 2) && (window.b2t === true))
        {
            setTimeout(function ()
            {
                ghost2DefeatedVisible ? (ghost2DefeatedVisible = false) : (ghost2DefeatedVisible = true);
                blinck(2)
            }, 500);
        }
    }


    function updateTime()
    {
        date = new Date();
        minutes = date.getMinutes();
        hour = date.getHours() % 12;
        seconds = date.getSeconds();
        milliseconds = date.getMilliseconds();
    }

    function draw()
    {
        ClockStyleKit.clearCanvas('mainCanvas');
        ClockStyleKit.drawPCanvas('mainCanvas', minutes * (-6), seconds * (-6) - milliseconds * (0.006), hour * (-30) - minutes * (0.5),
            pacmanstate[0], pacmanstate[1], pacmanstate[2], pacmanstate[3],
            ghost1Visible, ghost2Visible, ghost1DefeatedVisible, ghost2DefeatedVisible,
            ClockStyleKit.makeRect(0, 0, container.width(), container.height()), "aspectfit");
    }

    function upDatePacmanState()
    {
        let i = 0;
        while (i < pacmanstate.length)
        {
            if (pacmanstate[i] === true)
            {
                pacmanstate[i] = false;
                if (pacmanstate.length - 1 === i)
                {
                    pacmanstate[0] = true;
                }
                else
                {
                    i++;
                    pacmanstate[i] = true;
                }
            }
            i++;
        }
    }
}

