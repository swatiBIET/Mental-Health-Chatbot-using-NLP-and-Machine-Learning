import random
import json
import torch
from model import NeuralNet
from nltk_utils import bag_of_words, tokenize

device = torch.device('cuda' if torch.cuda.is_available() else 'cpu')

with open("intents.json", "r") as json_data:
    intents = json.load(json_data)

FILE = "data.pth"
data = torch.load(FILE)
input_size = data["input_size"]
hidden_size = data["hidden_size"]
output_size = data["output_size"]
all_words = data['all_words']
tags = data['tags']
model_state = data["model_state"]

model = NeuralNet(input_size, hidden_size, output_size).to(device)
model.load_state_dict(model_state)
model.eval()

flag = [
    "feel_bad",
    "insomnia",
    "Hypersomnia",
    "smoking_true",
    "smoking_from_stress",
    "smoking_from_anxiety",
    "smoking_from_emotions",
    "drinking_true",
    "relations_bad",
    "stress_true",
    "stress_from_work",
    "stress_from_relationships",
    "stress_from_finances",
    "stress_and_health",
    "stress_with_sleep",
    "stress_in_the_morning",
    "stress_and_emotions",
    "stress_overload",
    "stress_and_loneliness",
    "depression_true",
    "depression_from_failures",
    "depression_from_comparison",
    "depression_from_uncertainty",
    "depression_from_lack_of_motivation",
    "self_esteem_low",
    "anger_true",
    "frustration",
    "frustration_with_work_studies",
    "frustration_with_relationships",
    "frustration_with_personal_goals",
    "frustration_with_lack_of_progress",
    "frustration_with_time_management",
    "frustration_with_self",
    "frustration_with_finances",
    "hopeful_false",
    "joy_false",
    "hopeless_false_vision",
    "fear_true",
    "self_doubt_true",
    "sleep_disorders",
    "dreams_and_nightmares",
    "panic_attack_true",
    "negative_thinking",
    "anxious_true",
    "anxiety_from_work",
    "anxiety_from_overthinking",
    "anxiety_from_health",
    "anxiety_from_sleep",
    "anxiety_from_life_changes",
    "general_anxiety",
    "social_anxiety",
    "chronic_fatigue",
    "isolation",
    "self_doubt",
    "mood_swings",
    "imposter_syndrome",
    "fear_of_the_future",
    "overthinking",
    "addiction",
    "behavioral_addiction",
    "exercise_addiction",
    "food_addiction",
    "gambling_addiction",
    "porn_addiction",
    "shopping_addiction",
    "work_addiction",
    "technology_addiction",
    "workaholism",
    "social_media_emotion",  # borderline, based on context
    "emotional_overwhelm",
    "crying_true",
    "loneliness_true",
    "hopeless_true",
    "harm_true"
]
bot_name = "Sam"
count=0
total=0


def get_response(msg):
    global flag
    global count
    global total
    sentence = tokenize(msg)
    X = bag_of_words(sentence, all_words)
    X = X.reshape(1, X.shape[0])
    X = torch.from_numpy(X).to(device)

    output = model(X)
    _, predicted = torch.max(output, dim=1)

    tag = tags[predicted.item()]

    probs = torch.softmax(output, dim=1)
    prob = probs[0][predicted.item()]
    if prob.item() > 0.50:
        for intent in intents['intents']:
            if tag == intent["tag"]:
                total += 1
                if(tag in flag):
                    count += 1
                # Calculate the mental health score
                score = round((total - count) * 100 / total, 2)

                # Check if the score is below 40%
                if score < 40:
                    return (f"Your mental health score is: {score}%<br><br>It seems like you might need some extra support.<br><br>"
                            "Click on the link below to get a list of Psychiatrists near you:<br/>"
                            "<a href='https://curofy.com/doctors/belgaum,-karnataka,-india/psychiatry' target='_blank'>Doctors List</a>")
                
                # If the score is not below 40%, return regular response
                if tag == "harm_false" or tag=="good bye":
                    return f"Your mental health score is : {score}%<br><br>Have a good day!"
                
                # Return regular responses for other tags
                return random.choice(intent['responses'])
    return "I do not understand..."

