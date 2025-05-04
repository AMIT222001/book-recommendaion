from flask import Flask, request, jsonify
import pickle
import numpy as np

app = Flask(__name__)

# Load your pickled data
popular_df = pickle.load(open('popular.pkl', 'rb'))
pt = pickle.load(open('pt.pkl', 'rb'))
books = pickle.load(open('books.pkl', 'rb'))
similarity_scores = pickle.load(open('similarity_scores.pkl', 'rb'))

@app.route('/recommend_books', methods=['POST'])
def recommend():
    try:
        # Get JSON data from the request
        data = request.get_json()
        user_input = data.get('user_input')
        print(user_input)
        if not user_input:
            return jsonify({"error": "Missing user_input"}), 400

        # Find the book index
        index = np.where(pt.index == user_input)[0][0]
        similar_items = sorted(list(enumerate(similarity_scores[index])), key=lambda x: x[1], reverse=True)[1:5]

        recommendations = []
        for i in similar_items:
            temp_df = books[books['Book-Title'] == pt.index[i[0]]]

            item = {
                "book_name": temp_df['Book-Title'].values[0],
                "author": temp_df['Book-Author'].values[0],
                "image": temp_df['Image-URL-M'].values[0]
            }

            # Convert numpy data types to standard Python types
            item = {k: (int(v) if isinstance(v, np.integer) else v) for k, v in item.items()}
            recommendations.append(item)

        return jsonify({"recommendations": recommendations})

    except IndexError:
        return jsonify({"error": "Book not found"}), 404
    except Exception as e:
        return jsonify({"error": str(e)}), 500

if __name__ == '__main__':
    app.run(debug=True)
