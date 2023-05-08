// import "./App.css";
import { Box, Button } from "@mui/material";
import useMounted from "react-use-mounted";
import { apiRef } from "./api/apiRef";
import { useCallback, useEffect, useState, useRef } from "react";

// componentDidUpdate(prevProps, prevState){
//   Object.entries(this.props).forEach(([key, val]) =>
//     prevProps[key] !== val && console.log(`Prop '${key}' changed`)
//   );
//   if (this.state) {
//     Object.entries(this.state).forEach(([key, val]) =>
//       prevState[key] !== val && console.log(`State '${key}' changed`)
//     );
//   }
// }

function App() {
  const mounted = useMounted();
  const [isLoading, setIsLoading] = useState(false);
  const [ticket, setTicket] = useState(null);
  const [values, setValues] = useState([]);
  const valuesKeyName = [];

  const [displayValues, setDisplayValues] = useState([]);

  const [displayButtons, setDisplayButtons] = useState([]);
  const [displayGain, setDisplayGain] = useState(false);

  // création du tableau des noms des clefs des valeurs du ticket
  for (let i = 1; i <= 8; i++) {
    valuesKeyName.push("value_" + i);
  }

  const playing = useCallback(async () => {
    try {
      setIsLoading(true);
      const data = await apiRef.playing(process.env.REACT_APP_URL + "playing");
      if (mounted.current) {
        setIsLoading(false);
        console.log(data);
        setTicket(data);
        // initialisation de l'affichage à false des valeurs et true des boutons
        let tempFillDisplayValues = [];
        let tempFillDisplayButtons = [];
        for (let i = 1; i <= 8; i++) {
          tempFillDisplayValues.push(false);
          tempFillDisplayButtons.push(true);
        }
        setDisplayValues(tempFillDisplayValues);
        setDisplayButtons(tempFillDisplayButtons);
      }
    } catch (err) {
      console.error(err);
    }
  }, [mounted]);

  useEffect(() => {
    playing();
  }, [playing]);

  useEffect(() => {
    if (ticket !== null) {
      let tempValues = [];
      valuesKeyName.forEach((key) => {
        tempValues.push(ticket[key]);
      });
      setValues(tempValues);
    }
  }, [ticket]);

  const handleDisplayValue = (index) => {
    let countDiscoveredValues = 0;
    const tempDisplayValues = [...displayValues];
    tempDisplayValues[index] = true;
    // console.log(tempDisplayValues);
    setDisplayValues(tempDisplayValues);
    const tempDisplayButtons = [...displayButtons];
    tempDisplayButtons[index] = false;
    setDisplayButtons(tempDisplayButtons);
    tempDisplayValues.forEach((displayValue) => {
      if (displayValue) {
        countDiscoveredValues++;
      }
    });
    if (countDiscoveredValues === 8) {
      setDisplayGain(true);
    }
  };

  useEffect(() => {
    console.log(values);
  }, [values]);

  // useEffect(() => {
  //   console.log(displayValues);
  // }, [displayValues]);

  return (
    <Box>
      {isLoading ? (
        <Box>Chargement</Box>
      ) : (
        <Box>
          <Box>Accueil</Box>
          {values.map((value, index) => {
            return (
              <Box key={index}>
                {displayValues[index] && <Box>{value}</Box>}
                {displayButtons[index] && (
                  <Button onClick={() => handleDisplayValue(index)}>
                    Dévoiler
                  </Button>
                )}
              </Box>
            );
          })}
          {displayGain && ticket.gain !== 1000000 && (
            <Box>{`Gain : ${ticket.gain}`}</Box>
          )}
          {displayGain && ticket.gain === 1000000 && <Box>Jackpot</Box>}
        </Box>
      )}
    </Box>
  );
  // return <Box>test</Box>;
}

export default App;
