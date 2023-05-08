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
  // const [displayValues, setDisplayValues] = useState([
  //   false,
  //   false,
  //   false,
  //   false,
  //   false,
  //   false,
  //   false,
  //   false,
  // ]);
  const [displayValues, setDisplayValues] = useState([]);
  // const [displayButtons, setDisplayButtons] = useState([
  //   true,
  //   true,
  //   true,
  //   true,
  //   true,
  //   true,
  //   true,
  //   true,
  // ]);
  const [displayButtons, setDisplayButtons] = useState([]);

  // création du tableau des noms des clefs des valeurs du ticket et initialisation de l'affichage à false des valeurs et boutons
  // let tempDisplayValues = [];
  for (let i = 1; i <= 8; i++) {
    valuesKeyName.push("value_" + i);
    // tempFillDisplayValues.push(false);
    // displayButtons.push(true);
  }
  // if (tempFillDisplayValues.length === 8) {
  //   setDisplayValues(tempFillDisplayValues);
  // }

  const playing = useCallback(async () => {
    try {
      setIsLoading(true);
      const data = await apiRef.playing(process.env.REACT_APP_URL + "playing");
      if (mounted.current) {
        setIsLoading(false);
        console.log(data);
        setTicket(data);
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
        // console.log(values);
        // tempValues = [...values];
        tempValues.push(ticket[key]);
        // console.log(tempValues);
      });
      setValues(tempValues);
    }
  }, [ticket]);

  const handleDisplayValue = (index) => {
    const tempDisplayValues = [...displayValues];
    tempDisplayValues[index] = true;
    console.log(tempDisplayValues);
    setDisplayValues(tempDisplayValues);
    const tempDisplayButtons = [...displayButtons];
    tempDisplayButtons[index] = false;
    setDisplayButtons(tempDisplayButtons);
  };

  useEffect(() => {
    console.log(values);
  }, [values]);

  useEffect(() => {
    console.log(displayValues);
  }, [displayValues]);

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
        </Box>
      )}
    </Box>
  );
  // return <Box>test</Box>;
}

export default App;
